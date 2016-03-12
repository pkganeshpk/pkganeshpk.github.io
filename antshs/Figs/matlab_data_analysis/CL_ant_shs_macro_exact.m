% CL_ANT_SHS_MACRO_EXACT     Closed-loop ant stochastic hybrid system, exact population model
%
%   This script performs a poopulation simulation of an SHS of ants. Rather
%   than proceeding at uniform time intervals, it calculates the exact next
%   time of an event. Consequently, events can be asynchronous.

clear all

%%%%%% SET SIMULATION PARAMETERS

% Number of MC runs
M = 100;

% Number of ants
N = 100;

% Maximum length of simulation
SIM_TIME = 10;

% State names
state_names = { 'pulling-left', 'pulling-right', 'lifting', 'unattached' };
stateind = containers.Map( state_names, 1:length(state_names) );

% State transition rates (zero down the diagonal)
%lambda = (1 - eye(length(state_names))).*reshape(1:(length(state_names)^2), length(state_names), length(state_names))'/length(state_names)^2 * 0.3;
%lambda = (1 - eye(3)).*[1 2 3; 4 5 6; 7 8 9]/9*0.3;
lambda = (1 - eye(3)).*[0 0 0; 1 0 1; 0 0 0]*0.3;
%rng shuffle
%lambda = (1 - eye(3)).*reshape( randperm(9), 3, 3 )*0.3;
%lambda = (1 - eye(3)).*rand(3,3)*0.3;

% Physical parameters
mL = 10;
mu = 0.05;
Fpg = 0.2;
vd = 1;
Fl = 2;
g = 9.8;


%%%%%% PREPARE SIMULATION

% Maximum time step size (to be sure to capture smooth continuous features)
MAX_TIME_STEP = 0.125;

% History (and initial position and velocity)
clear time x v
[time{1:M}] = deal(0);
[x{1:M}] = deal(0);
[v{1:M}] = deal(0);
[d{1:M}] = deal(sign(v{1}));

% History of number in each state
num_in_state = {};


%%%%%% RUN M MONTE CARLO RUNS

% Pre-allocate some memory for speed

% Used to keep track of accumulated encounter rate within states
% (i.e., (number in state)*(sum of per-individual rates in that state))
statelambda = zeros(1, length(lambda));

% Used when enumerating edges to draw state transition with one draw
% rather than two
% - eventlambda lets draw over edges
% - lambdex and num_in_states allows for encoding and decoding the
%   enumeration
lambdex = zeros(length(lambda)-1, length(lambda));
eventlambda = zeros(N*(length(lambda)-1), 1);
num_in_states = zeros(1,length(lambda));

rng shuffle
for mcrun = 1:M

    % Initial allocation of ants to states
    num_allocated = 0;
%    stateperm = 1:length(lambda);
%    stateperm = randperm(length(lambda));
    stateperm = [2 3 1];
    for i = 1:length(stateperm)
        if i == length(stateperm)
            num_in_state{stateperm(i)}{mcrun}(1) = N - num_allocated; %#ok<SAGROW>
        else
            num_in_state{stateperm(i)}{mcrun}(1) = randi([0 N-num_allocated]); %#ok<SAGROW>
        end
        statelambda(stateperm(i)) = num_in_state{stateperm(i)}{mcrun}(1) * sum(lambda(:,stateperm(i)));
        num_allocated = num_allocated + num_in_state{stateperm(i)}{mcrun}(1);
    end

    % Calculate the time of the first event
    next_event_time = time{mcrun}(end) + random( 'exp', 1/sum(statelambda) );
    if next_event_time > SIM_TIME
        next_event_time = SIM_TIME;
        real_event = false;
    else
        real_event = true;
    end

    % Discrete event simulation
    % - Generate and iterate over events in same loop
    new_event_to_process = true;
    while new_event_to_process
        %
        % FIRST, use discrete states at previous event to calculate
        % continuous evolution up to this event.
        %

        % Acceleration from analysis
        Fn = max(0, mL*g - num_in_state{stateind('lifting')}{mcrun}(end)*Fl);
        Fg = (num_in_state{stateind('pulling-right')}{mcrun}(end) - num_in_state{stateind('pulling-left')}{mcrun}(end))*Fpg*(vd - v{mcrun}(end));
        if v{mcrun}(end) == 0 && abs(Fg) < mu*Fn
            % Not enough force to overcome friction at stop
            accel = 0;
        else
            % Either already moving or have enough force to overcome
            % friction from a stop
            accel = (Fg - sign(v{mcrun}(end))*mu*Fn)/mL;
        end

        % With calculated acceleration, integrate continuous position and
        % velocity. If a stop is detected, stop the loop early and process
        % the stop as its own event.
        dT = next_event_time - time{mcrun}(end);
        if v{mcrun}(end) ~= 0 && accel ~= 0 && sign( v{mcrun}(end) ) ~= sign( accel ) && dT > abs( v{mcrun}(end) / accel )
            % A stop is predicted before next_event_time.
            % (i.e., object will stop before any discrete states are
            %  scheduled to change)

            dT = abs( v{mcrun}(end) / accel );
            x{mcrun}(end+1) = x{mcrun}(end) + v{mcrun}(end)*dT + 0.5*accel*dT^2;
            v{mcrun}(end+1) = 0;
            d{mcrun}(end+1) = 0;
            time{mcrun}(end+1) = time{mcrun}(end) + dT;

            % Stop happens before next state transition, and so state
            % numbers stay the same
            for state = 1:length(lambda)
                num_in_state{state}{mcrun}(end+1) = num_in_state{state}{mcrun}(end); %#ok<SAGROW>
            end
        elseif next_event_time > time{mcrun}(end) + MAX_TIME_STEP
            % Make sure we capture interesting features of continuous
            % dynamics
            x{mcrun}(end+1) = x{mcrun}(end) + v{mcrun}(end)*MAX_TIME_STEP + 0.5*accel*MAX_TIME_STEP^2;
            v{mcrun}(end+1) = v{mcrun}(end) + accel*MAX_TIME_STEP;
            d{mcrun}(end+1) = sign(v{mcrun}(end));
            time{mcrun}(end+1) = time{mcrun}(end) + MAX_TIME_STEP;

            % Stop happens before next state transition, and so state
            % numbers stay the same
            for state = 1:length(lambda)
                num_in_state{state}{mcrun}(end+1) = num_in_state{state}{mcrun}(end); %#ok<SAGROW>
            end
        else
            x{mcrun}(end+1) = x{mcrun}(end) + v{mcrun}(end)*dT + 0.5*accel*dT^2;
            v{mcrun}(end+1) = v{mcrun}(end) + accel*dT;
            d{mcrun}(end+1) = sign(v{mcrun}(end));
            time{mcrun}(end+1) = next_event_time;

            %
            % SECOND, calculate discrete state changes at this event
            %

            % Assume no state changes
            state_change = zeros(1,length(lambda));

            if real_event
                % This event was generated by an encounter and not the end of
                % simulation

                % This short method uses two random draws to determine
                % focal and new states
                statelambda = zeros(1, length(lambda));
                for state = 1:length(lambda)
                    statelambda(state) = num_in_state{state}{mcrun}(end) * sum(lambda(:,state));
                end
                focal_state = nnz( rand > cumsum( statelambda/sum(statelambda) ) ) + 1;
                new_state = nnz( rand > cumsum( lambda(:,focal_state)/sum(lambda(:,focal_state)) ) ) + 1;

                % This longer method enumerates all edges and uses one draw
                % to determine focal and new state simultaneously
                %offset = 0;
                %for state = 1:length(lambda)
                %    num_in_states(state) = num_in_state{state}{mcrun}(end);
                %    lambdex(1:(length(lambda)-1), state) = [ 1:(state-1),(state+1):length(lambda) ]';
                %    eventlambda( offset + (1:(num_in_states(state)*(length(lambda)-1))) ) = repmat( lambda(lambdex(:,state),state), num_in_states(state), 1 );
                %    offset = offset + num_in_states(state)*(length(lambda)-1);
                %end
                %focal_event = nnz( rand > cumsum( eventlambda/sum(eventlambda) ) ) + 1;
                %focal_state = nnz( (floor( (focal_event-1)/(length(lambda)-1) ) + 1) > cumsum( num_in_states ) ) + 1;
                %new_state = lambdex( mod( focal_event - 1, length(lambda)-1 ) + 1, focal_state );

                state_change([focal_state new_state]) = [-1 1];
            else
                % This event was generated by the end of the simulation
                new_event_to_process = false;
            end

            % Adjust state numbers as needed
            for state = 1:size(lambda)
                num_in_state{state}{mcrun}(end+1) = num_in_state{state}{mcrun}(end) + state_change(state); %#ok<SAGROW>
                statelambda(state) = num_in_state{state}{mcrun}(end) * sum(lambda(:,state));
            end

            %
            % THIRD, calculate time of next event based on updated
            % statelambdas
            %

            % Figure out next stop
            next_event_time = time{mcrun}(end) + random( 'exp', 1/sum(statelambda) );

            % If jumping over edge of simulation, create false event at end of
            % simulation
            if next_event_time > SIM_TIME
                next_event_time = SIM_TIME;
                real_event = false;
            end

        end

    end

end


%%%%%% GENERATE STATISTICS


% Generate sample statistics from MC runs

% Sample the MC run data at regular interval
sdT = 1/(20*N*sum(lambda(:)));
stime = time{1}(1):sdT:SIM_TIME;
sx = zeros(M, length(stime));
sv = zeros(M, length(stime));
sd = zeros(M, length(stime));
for state = 1:length(lambda)
    snum_in_state{state} = zeros(M, length(stime)); %#ok<SAGROW>
end
for mcrun = 1:M
    samples = sum(meshgrid(stime, time{mcrun}) >= meshgrid(time{mcrun}, stime)');
    sx(mcrun,:) = x{mcrun}(samples);
    sv(mcrun,:) = v{mcrun}(samples);
    sd(mcrun,:) = d{mcrun}(samples);
    for state = 1:length(lambda)
        snum_in_state{state}(mcrun,:) = num_in_state{state}{mcrun}(samples); %#ok<SAGROW>
    end
end

mean_x = mean( sx );
mean_x_SEM = grpstats( sx, [], 'sem' );
mean_d = mean( sd );
mean_d_SEM = grpstats( sd, [], 'sem' );
mean_counts = zeros(length(stime), length(lambda));
mean_counts_SEM = zeros(length(stime), length(lambda));
for state = 1:length(lambda)
    mean_counts(:, state) = mean( snum_in_state{state} )';
    mean_counts_SEM(:, state) = grpstats( snum_in_state{state}, [], 'sem' )';
end


% Generate predicted moment trajectory from mean-field approximation
initial_mean_state = zeros(length(lambda) + 2, 1);
for state = 1:length(lambda)
    initial_mean_state(state) = mean(snum_in_state{state}(:,1));
end
initial_mean_state(length(lambda)+1) = mean_x(1);
initial_mean_state(length(lambda)+2) = mean( sv(:, 1) );
laplacian = lambda.*(1-eye(size(lambda))) - (1-eye(size(lambda)))*lambda.*eye(size(lambda));
stateeye = eye(length(lambda));
pullvec = zeros(1,length(lambda));
pullvec( stateind('pulling-right') ) = 1;
pullvec( stateind('pulling-left') ) = -1;
vdot = (Fp*vd/mL) * pullvec;
auglaplacian = [ laplacian zeros(length(lambda),2) ;
                 zeros(1,length(lambda)) 0 1 ;
                 vdot 0 0 ];
[t, mean_field_counts] = ode45( @(tnow,meanstate)(auglaplacian*meanstate - [ zeros(length(lambda)+1,1) ; Fpg*meanstate(end)*(meanstate(stateind('pulling-right')) - meanstate(stateind('pulling-left')))/mL ]), stime, initial_mean_state );

% Generate likely mean-field approximation using sampled d mean
%ds_mean_field_counts = zeros(length(stime),length(lambda)+2);
[dst, ds_mean_field_counts] = ode45( @(tnow,meanstate)( auglaplacian*meanstate ...
                                                        - [ zeros(length(lambda)+1,1) ; Fpg*meanstate(end)*(meanstate(stateind('pulling-right')) - meanstate(stateind('pulling-left')))/mL ] ...
                                                        + [ zeros(length(lambda)+1,1) ; mean_d(nnz(tnow>stime)+1)*mu*(Fl/mL)*meanstate(stateind('lifting')) ] ...
                                                        - [ zeros(length(lambda)+1,1) ; mean_d(nnz(tnow>stime)+1)*mu*g ] ), stime, initial_mean_state );

%%%%%% REPORT STATISTICS

cmap = jet(M);

% Plot continuous variable over time
figure(1);
clf;
subplot(2,1,1);
% plot( stime, sx );
hold on;
for i = 1:M
    plot( time{i}, x{i}, '-', 'Color', cmap(i,:) );
end
%hold on;
smeanfig = errorbar( stime, mean_x, mean_x_SEM, 'k--' );
dsmfafig = plot( dst, ds_mean_field_counts(:,length(lambda)+1), 'b--o' );
zfmfafig = plot( t, mean_field_counts(:,length(lambda)+1), 'r--d' );
meanfig = [ smeanfig zfmfafig dsmfafig ];
set( smeanfig, 'LineWidth', 2 );
hold off;
xlim([0 SIM_TIME]);
xlabel( 'Time' );
ylabel( 'Position' );
title( sprintf( 'Continuous trajectories [%d ants, %d MC trials]', N, M ) );
legh = legend( meanfig, 'Sample mean \pm SEM', ...
               'Zero-friction MFA', ...
               'd-Sampled MFA', ...
               'Location', 'NorthWest' );
set(legh, 'Color', 'green');

% Plot direction over time
subplot(2,1,2);
% stairs( stime, sd' );
hold on;
for i = 1:M
    plot( time{i}, d{i}, '-', 'Color', cmap(i,:) );
end
%hold on;
dmeanfig = errorbar( stime, mean_d, mean_d_SEM, 'k--' );
set( dmeanfig, 'LineWidth', 2 );
hold off;
xlim([0 SIM_TIME]);
ylim([-1.1 1.1]);
xlabel( 'Time' );
ylabel( 'Direction (left (-1), stop (0), right (1))' );
legh = legend( dmeanfig, 'Sample mean \pm SEM', 'Location', 'NorthWest' );
set(legh, 'Color', 'green');


% Plot population trajectories from MC runs overlayed with stats and
% predictions
figure(2);
clf;
uipanel( 'Title', sprintf( 'Discrete trajectories [%d ants, %d MC trials]', N, M ), 'TitlePosition', 'centertop' );
subplot_rows = [ 1 2 3, 2 2 2, 3 3 3, 3 3 3, 4 4 4, 4 4 4 ];
subplot_cols = [ 1 1 1, 2 2 2, 3 3 3, 4 4 4, 4 4 4, 4 5 5 ];

for state = 1:length(lambda)
    subplot(subplot_rows(length(lambda)),subplot_cols(length(lambda)),state);
    %stairs( stime, snum_in_state{state}' );
    hold on;
    for i = 1:M
        stairs( time{i}, num_in_state{state}{i}', 'Color', cmap(i,:) );
    end
    smeanfig = errorbar( stime, mean_counts(:,state), mean_counts_SEM(:,state), 'k--' );
    mfafig = plot( t, mean_field_counts(:,state), 'r--' );
    meanfig = [smeanfig mfafig];
    set( meanfig, 'LineWidth', 2 );
    hold off;
    xlim([0 SIM_TIME]);
    xlabel( 'Time' );
    ylabel( sprintf('Number of %s ants', state_names{state} ) );
    legh = legend( meanfig, 'Sample mean \pm SEM', 'Mean-field approx' );
    set(legh, 'Color', 'green');
end