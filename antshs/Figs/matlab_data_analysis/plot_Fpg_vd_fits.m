function plot_Fpg_vd_fits(Fpg, vd, randreplicates, lambda)
% PLOT_FPG_VD_FITS   Fit (Fpg, vd) to Aurelie's data.
%
%   Try:
%       plot_Fpg_vd_fits( 0.0079, 0.5971, [1 6 11 12 13] )
%   for a nice example.

% Known parameters
mL = 0.0023; % 2.3g in kilograms
mu = 0.58;
g = 9.8; % 9.8 m/s/s
Fl = 0.0003; % 0.3 mN

%% Load and parse the data
load transportsegments

dT = 5;
t = dT*( 1:size( distanceSegment, 1 ) );

% Continuous variables
v = distanceSegment'/dT;
% a = [ NaN(size(distanceSegment, 2), 1) diff(v')'/dT ];
x = cumsum( distanceSegment )';

% Discrete counts
front_ants = antspulling';
back_ants = antspushing';
detached_ants = repmat( max( front_ants + back_ants ), size(front_ants,1), 1 ) - (front_ants + back_ants);

num_replicates = size(front_ants,1);

%% Plot raw continuous data for a subset of the replicates

% If only two parameters were provided, pick five random replicates.
% Otherwise, use replicates specified in third parameter.
if nargin < 3 || isempty(randreplicates)
    randreplicates = randperm(num_replicates);
    randreplicates = randreplicates(1:5);
end

figure(1);
for i = 1:length(randreplicates)
    fprintf( '* Generating continuous trajectory for replicate %d. Please wait...\n', randreplicates(i) );
    % Generate continuous trajectories for (Fpg, vd) pair using raw counts
    [~, ctsstate] = ode15s( @(tau,ctsstate)( segment_field( tau, ctsstate, Fpg, vd, randreplicates(i), front_ants, back_ants, t, Fl, mL, mu, g ) ), ...
                                        t, [ x(randreplicates(i),1); v(randreplicates(i),1) ] );

    ctsstate = ctsstate';

    % Plot raw counts, raw position and velocity, and predicted position
    % and velocity for (Fpg, vd) pair

    countymax = front_ants(randreplicates(i),1) + back_ants(randreplicates(i),1) + detached_ants(randreplicates(i),1);

    subplot(length(randreplicates),4,(i-1)*4 + 1);
    stairs( t, front_ants(randreplicates(i),:), '-o' )
    ylim([0 countymax])
    xlabel( 'Time (sec)');
    ylabel( '# Front Ants' );
    title( sprintf( 'replicate ID (repl) = %d', randreplicates(i) ) );

    subplot(length(randreplicates),4,(i-1)*4 + 2);
    stairs( t, back_ants(randreplicates(i),:), '-o' )
    ylim([0 countymax])
    xlabel( 'Time (sec)');
    ylabel( '# Back Ants' );
    title( sprintf( 'replicate ID (repl) = %d', randreplicates(i) ) );

    subplot(length(randreplicates),4,(i-1)*4 + 3);
    plot( t, x(randreplicates(i),:), 'o', t, ctsstate(1,:), '--' )
    ylims = ylim;
    ylim([0 max(ylims)]);
    xlabel( 'Time (sec)');
    ylabel( 'Position (cm)' );
    title( sprintf( 'repl = %d, F_{pg} = %0.4f, v_d = %0.4f', randreplicates(i), Fpg, vd ) );
    legend('Sampled', 'Predicted', 'Location', 'NorthWest');

    subplot(length(randreplicates),4,(i-1)*4 + 4);
    plot( t, v(randreplicates(i),:), 'o', t, ctsstate(2,:), '--' )
    ylims = ylim;
    ylim([0 max(ylims)]);
    xlabel( 'Time (sec)');
    ylabel( 'Velocity (cm/sec)' );
    title( sprintf( 'repl = %d, F_{pg} = %0.4f, v_d = %0.4f', randreplicates(i), Fpg, vd ) );
    legend('Sampled', 'Predicted', 'Location', 'NorthWest');
end

%% Next, plot the (Fpg,vd) pair on top of mean fields

% Calculate means from data
mean_x = mean(x);
mean_v = mean(v);
%mean_a = mean(a);
mean_front = mean( front_ants );
mean_back = mean( back_ants );
mean_detached = mean( detached_ants );

% Generate sampled mean state vector
meandata = [ mean_front; mean_back; mean_detached; mean_x; mean_v ];

if nargin < 4
    % A rate matrix was not provided, and so fit one from data

    fprintf( '* Because rate matrix (R) was not provided, fitting one from data. Please wait...\n' );

    num_dstates = 3;
    num_rates = num_dstates*(num_dstates - 1);

    [estparams, fval, exitflag] = ...
        fmincon( @(params)( dlsmetric(params, t, meandata(1:num_dstates,:)) ), ...
                0.5*randperm(num_rates)/num_rates, ...
                [], [], ... % inequalities (A*x <= b)
                [], [], ... % equalities (Aeq*x == beq)
                zeros(num_rates,1), ... % lower bounds
                (1/(2*dT))*ones(num_rates,1), ... % upper bounds
                [], ... % non-linear constraint
                optimset('Algorithm', 'active-set', ...
                         'Display', 'off', ... % 'off', 'iter', or 'final'
                         'FunValCheck', 'on', ...
                         'MaxFunEvals', 1300 ) ...
                ); %#ok<ASGLU,NASGU>

    % These lines turn the estlv vector into an estimated rate matrix estlambda
    lambda = zeros( num_dstates );
    offdiagonals = setdiff(1:(length(lambda))^2, ...
                           (1:length(lambda))+length(lambda)*((1:length(lambda))-1));
    lambda(offdiagonals) = estparams(1:num_rates);
end

% Interpolate between sampled time vector
simtime = linspace(min(t),max(t),length(t)*5);

% Generate the mean-field approximation based on lambda and the parameters
fprintf( '* Generating mean-field trajectories based on lambda, Fpg, and vd. Please wait...\n' );
[~, meanfield] = ode15s( @(tau,meanstate)( mfa_field( tau, meanstate, Fpg, vd, lambda, Fl, mL, mu, g ) ), ...
                         simtime, meandata(:,1) );

meanfield = meanfield';

% Plot the mean-field approximation
figure(2);

countymax = meandata(1,1) + meandata(2,1) + meandata(3,1);

subplot(2,6,[1 2]);
plot( t, meandata(1,:), 'o', simtime, meanfield(1,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Front' );
title( sprintf( 'r_{BF} = %0.4f, r_{DF} = %0.4f', lambda(1,2), lambda(1,3) ) );
legend('Sampled Mean', 'Model Mean', 'Location', 'NorthWest');

subplot(2,6,[3 4]);
plot( t, meandata(2,:), 'o', simtime, meanfield(2,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Back' );
title( sprintf( 'r_{FB} = %0.4f, r_{DB} = %0.4f', lambda(2,1), lambda(2,3) ) );
legend('Sampled Mean', 'Model Mean', 'Location', 'SouthEast');

subplot(2,6,[5 6]);
plot( t, meandata(3,:), 'o', simtime, meanfield(3,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Detached' );
title( sprintf( 'r_{FD} = %0.4f, r_{BD} = %0.4f', lambda(3,1), lambda(3,2) ) );
legend('Sampled Mean', 'Model Mean');

subplot(2,6,[7 8 9]);
plot( t, meandata(4,:), 'o', simtime, meanfield(4,:), '--' )
ylims = ylim;
ylim([0 max(ylims)]);
xlabel( 'Time (sec)');
ylabel( 'Position (cm)' );
title( sprintf( 'F_{pg} = %0.4f, v_d = %0.4f', Fpg, vd ) );
legend('Sampled Mean', 'Model Mean', 'Location', 'NorthWest');

subplot(2,6,[10 11 12]);
plot( t, meandata(5,:), 'o', simtime, meanfield(5,:), '--' )
ylims = ylim;
ylim([0 max(ylims)]);
xlabel( 'Time (sec)');
ylabel( 'Velocity (cm/sec)' );
title( sprintf( 'F_{pg} = %0.4f, v_d = %0.4f', Fpg, vd ) );
legend('Sampled Mean', 'Model Mean', 'Location', 'NorthWest');

end

%% Helpers

% Differential field for per-segment (x,v) predictions
function [field] = segment_field( tau, ctsstate, Fpg, vd, replicate, front_ants, back_ants, t, Fl, mL, mu, g )
%    [~, ti] = min( abs(t-tau) );
%    ti = nnz( tau <= t );
%    ti = (t == tau);
    ti = find( tau >= t, 1, 'last' );

    % Either force direction (d) to 1, or make it depend on velocity
    %d = sign(ctsstate(2));
    d = 1;

    % Negative normal forces cause friction to "help" rather than hurt.
    % To prevent them, set min_normal_force to 0. To embrace linearity of
    % the model, set min_normal_force to -Inf.
    % (note: if Fl/mL is small, this should make no difference)
    min_normal_force = 0;
    %min_normal_force = -Inf;
 
    field = [0 1; 0 0]*ctsstate ...
            + [0; Fpg*(vd - ctsstate(2))*front_ants(replicate,ti)/mL ] ...
            - [0; d*mu*max(min_normal_force, g - (Fl/mL)*(front_ants(replicate,ti)+back_ants(replicate,ti)) ) ];

end

% Differential field for mean-field (x,v) predictions
function [field] = mfa_field( tau, meanstate, Fpg, vd, lambda, Fl, mL, mu, g ) %#ok<INUSL>

    % Use lambda to generate graph Laplacian
    laplacian = lambda.*(1-eye(size(lambda))) - (1-eye(size(lambda)))*lambda.*eye(size(lambda));

    % Augment the Laplacian with the double integrator
    auglaplacian = [ laplacian zeros(length(lambda),2) ;
                     zeros(1,length(lambda)) 0 1 ;
                     zeros(1,length(lambda)) 0 0 ];

    % Either force direction (d) to 1, or make it depend on velocity
    %d = sign(ctsstate(2));
    d = 1;

    % Negative normal forces cause friction to "help" rather than hurt.
    % To prevent them, set min_mean_normal_force to 0. To embrace linearity of
    % the model, set min_mean_normal_force to -Inf.
    % (note: if Fl/mL is small, this should make no difference)
    min_mean_normal_force = 0;
    %min_mean_normal_force = -Inf;

    field = auglaplacian*meanstate ...
            + [ zeros(length(lambda)+1,1) ; Fpg*(vd - meanstate(end))*meanstate(1)/mL ] ...
            - [ zeros(length(lambda)+1,1) ; d*mu*max(min_mean_normal_force, g - (Fl/mL)*(meanstate(1)+meanstate(2)) ) ];

end

% Least-squares metric for fitting transition rates
function lssum = dlsmetric( params, t, meandata )
    % This maps the number of elements in lambdavec to the number of states
    num_dstates = max( roots( [1 -1 -(length(params))] ) );

    % This generates a rate matrix whose diagonal entries are zero and all
    % off-diagonal entires come from lambdavec
    lambda = zeros( num_dstates );
    offdiagonals = setdiff(1:(num_dstates^2), ...
                           (1:num_dstates)+num_dstates*((1:num_dstates)-1));
    lambda(offdiagonals) = params;

    laplacian = lambda.*(1-eye(size(lambda))) - (1-eye(size(lambda)))*lambda.*eye(size(lambda));

    meanfield = zeros(size(meandata));
    meanfield(:,1) = meandata(:,1);
    for i = 2:length(t)
        meanfield(:,i) = expm( laplacian*t(i) )*meanfield(:,1);
    end

    % This sums up the squared differences over time
    lssum = 0;
    weights = 1./var(meandata,[],2);
    for i = 2:length(t)
        error = meanfield(:,i) - meandata(:,i);
        lssum = lssum + error'*diag(weights)*error;
    end

end

%#ok<*MFAMB>