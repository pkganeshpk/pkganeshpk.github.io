% OL_ANT_SHS_ABM   Open-loop ant stochastic hybrid system, approximate agent-based model
%
%   This script performs an agent-based simulation of an SHS of ants.
%   It proceeds at uniform time intervals, and thus all events appear to
%   happen on a synchronous clock.

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
lambda = (1 - eye(3)).*[1 2 3; 4 5 6; 7 8 9]/9*0.3;
%lambda = (1 - eye(3)).*[0 0 0; 1 0 1; 0 0 0]*0.3;
%rng shuffle
%lambda = (1 - eye(3)).*reshape( randperm(9), 3, 3 )*0.3;
%lambda = (1 - eye(3)).*rand(3,3)*0.3;

% Physical parameters
mL = 20;
mu = 0.2;
Fp = 2;
Fl = 1;
g = 9.8;


%%%%%% PREPARE SIMULATION

% Simulation interval based on rates
dT = 1/(100*mean(mean(lambda)));

% History (and initial position and velocity)
time = 0:dT:SIM_TIME;
x = zeros(M, length(time));
v = zeros(M, length(time));
d = sign(v);

% History of number attached, pulling, and lifting
for state = 1:length(lambda)
    num_in_state{state} = zeros(M, length(time)); %#ok<SAGROW>
end


%%%%%% RUN M MONTE CARLO RUNS

% Pre-allocate some memory for speed

% Will store current state of each ant
states = zeros(1,N);

rng shuffle
for mcrun = 1:M

    % Initial allocation of ants to states
    num_allocated = 0;
%    stateperm = 1:length(lambda);
    stateperm = randperm(length(lambda));
    for i = 1:length(stateperm)
        if i == length(stateperm)
            num_in_state{stateperm(i)}(mcrun, 1) = N - num_allocated; %#ok<SAGROW>
        else
            num_in_state{stateperm(i)}(mcrun, 1) = randi([0 N-num_allocated]); %#ok<SAGROW>
        end
        states(num_allocated + (1:num_in_state{stateperm(i)}(mcrun, 1))) = stateperm(i);
        num_allocated = num_allocated + num_in_state{stateperm(i)}(mcrun, 1);
    end

    % Discrete event simulation
    % - Generate and iterate over events in same loop
    for i = 2:length(time)

        % See if an event occurred on any ant
        for ant = 1:N
            % See which edge (if any) was activated during this interval
            next_state = nnz( rand > cumsum(lambda(:,states(ant))*dT) ) + 1;

            if next_state <= length(lambda)
                % An edge was activated
                states(ant) = next_state;
            end
        end

        % See how many ants are in each state during this interval
        for state = 1:length(lambda)
            num_in_state{state}(mcrun, i) = nnz( states == state ); %#ok<SAGROW>
        end

        % Acceleration from analysis
        Fn = max(0, mL*g - num_in_state{stateind('lifting')}(mcrun, i-1)*Fl);
        Fg = (num_in_state{stateind('pulling-right')}(mcrun, i-1) - num_in_state{stateind('pulling-left')}(mcrun, i-1))*Fp;
        accel = (Fg - sign(v(mcrun, i-1))*mu*Fn)/mL;

        if (v(mcrun, i-1) == 0 || (accel ~= 0 && sign( v(mcrun, i-1) ) ~= sign( accel ) && dT > abs( v(mcrun, i-1)/accel))) && abs(Fg) < mu*Fn
            % Object is either stopped or will stop during this interval
            % Additionally, force is not great enough to overcome friction
            % So come out of this interval stopped
            if v(mcrun, i-1) ~= 0
                tts = abs( v(mcrun, i-1)/accel );
                x(mcrun, i) = x(mcrun, i-1) + v(mcrun, i-1)*tts + 0.5*accel*tts^2;
            else
                x(mcrun, i) = x(mcrun, i-1);
            end
            v(mcrun, i) = 0;
            d(mcrun, i) = 0;
            accel = 0;
        else
            % Either already moving or have enough force to overcome
            % friction from a stop
            x(mcrun, i) = x(mcrun, i-1) + v(mcrun, i-1)*dT + 0.5*accel*dT^2;
            v(mcrun, i) = v(mcrun, i-1) + accel*dT;
            d(mcrun, i) = sign( v(mcrun, i) );
        end

    end

end


%%%%%% GENERATE STATISTICS


% Generate sample statistics from MC runs
mean_x = mean( x );
mean_x_SEM = grpstats( x, [], 'sem' );
mean_d = mean( d );
mean_d_SEM = grpstats( d, [], 'sem' );
mean_counts = zeros(length(time), length(lambda));
mean_counts_SEM = zeros(length(time), length(lambda));
for state = 1:length(lambda)
    mean_counts(:, state) = mean( num_in_state{state} )';
    mean_counts_SEM(:, state) = grpstats( num_in_state{state}, [], 'sem' )';
end

% Generate predicted moment trajectory from mean-field approximation
initial_mean_state = zeros(length(lambda) + 2, 1);
for state = 1:length(lambda)
    initial_mean_state(state) = mean(num_in_state{state}(:,1));
end
initial_mean_state(length(lambda)+1) = mean_x(1);
initial_mean_state(length(lambda)+2) = mean( v(:, 1) );
laplacian = lambda.*(1-eye(size(lambda))) - (1-eye(size(lambda)))*lambda.*eye(size(lambda));
stateeye = eye(length(lambda));
pullvec = zeros(1,length(lambda));
pullvec( stateind('pulling-right') ) = 1;
pullvec( stateind('pulling-left') ) = -1;
vdot = (Fp/mL) * pullvec;
auglaplacian = [ laplacian zeros(length(lambda),2) ;
                 zeros(1,length(lambda)) 0 1 ;
                 vdot 0 0 ];
%[t, mean_field_counts] = ode45( @(t,meanstate)(laplacian*meanstate), time, initial_mean_state );
t = time;
mean_field_counts = zeros(length(t),length(lambda)+2);
for i = 1:length(t)
    mean_field_counts(i,:) = expm(auglaplacian*t(i))*initial_mean_state;
end

% Generate likely mean-field approximation using sampled d mean
%d_mean_field_counts = zeros(length(time),length(lambda)+2);
[dt, d_mean_field_counts] = ode45( @(tnow,meanstate)( auglaplacian*meanstate ...
                                                        + [ zeros(length(lambda)+1,1) ; mean_d(nnz(tnow>time)+1)*mu*(Fl/mL)*meanstate(stateind('lifting')) ] ...
                                                        - [ zeros(length(lambda)+1,1) ; mean_d(nnz(tnow>time)+1)*mu*g ] ), time, initial_mean_state );



%%[t, mean_field_counts] = ode45( @(t,meanstate)(laplacian*meanstate), time, initial_mean_state );
%t = time;
%mean_field_counts = zeros(length(t),length(lambda));
%for i = 1:length(t)
%    mean_field_counts(i,:) = expm(laplacian*t(i))*initial_mean_state;
%end


%%%%%% REPORT STATISTICS

% Plot continuous variable over time
figure(1);
subplot(2,1,1);
plot( time, x );
hold on;
smeanfig = errorbar( time, mean_x, mean_x_SEM, 'k--' );
dsmfafig = plot( dt, d_mean_field_counts(:,length(lambda)+1), 'b--o' );
zfmfafig = plot( t, mean_field_counts(:,length(lambda)+1), 'r--d' );
meanfig = [ smeanfig zfmfafig dsmfafig ];
set( meanfig, 'LineWidth', 2 );
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
stairs( time, d' );
hold on;
dmeanfig = errorbar( time, mean_d, mean_d_SEM, 'k--' );
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
    stairs( time, num_in_state{state}' );
    hold on;
    smeanfig = errorbar( time, mean_counts(:,state), mean_counts_SEM(:,state), 'k--' );
    mfafig = plot( t, mean_field_counts(:,state), 'r--' );
    meanfig = [smeanfig mfafig];
    set( meanfig, 'LineWidth', 2 );
    hold off;
    xlim([0 SIM_TIME]);
    xlabel( 'Time' );
    ylabel( sprintf( 'Number of %s ants', state_names{state} ) );
    legh = legend( meanfig, 'Sample mean \pm SEM', 'Mean-field approx' );
    set(legh, 'Color', 'green');
end