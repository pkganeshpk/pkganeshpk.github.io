function [estlambda, estFpg, estvd, dwlsval, cwlsval, estmeanfield, meandata, t] = sepfit_Fpg_vd_mean_transport_segments
% SEPFIT_FPG_VD_MEAN_TRANSPORT_SEGMENTS   Fit (Fpg, vd) to means of Aurelie's
%   data, where rates are fitted first.

% [estlambda, estFpg, estvd, dwlsval, cwlsval, estmeanfield, meandata, t] = sepfit_Fpg_vd_mean_transport_segments;
%
% i=1; plot( t, meandata(i,:), '-', t, estmeanfield(i,:), '--' )
% i=2; plot( t, meandata(i,:), '-', t, estmeanfield(i,:), '--' )
% i=3; plot( t, meandata(i,:), '-', t, estmeanfield(i,:), '--' )
% i=4; plot( t, meandata(i,:), '-', t, estmeanfield(i,:), '--' )
% i=5; plot( t, meandata(i,:), '-', t, estmeanfield(i,:), '--' )

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

%% Calculate means
mean_x = mean(x); %#ok<UDIM>
mean_v = mean(v);
%mean_a = mean(a);

mean_front = mean( front_ants );
mean_back = mean( back_ants );
mean_detached = mean( detached_ants );

%% Generate mean state vector
meandata = [ mean_front; mean_back; mean_detached; mean_x; mean_v ];

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
                     'Display', 'iter', ...
                     'FunValCheck', 'on', ...
                     'MaxFunEvals', 1300 ) ...
            );  %#ok<NASGU>

% These lines turn the estlv vector into an estimated rate matrix estlambda
estlambda = zeros( num_dstates );
offdiagonals = setdiff(1:(length(estlambda))^2, ...
                       (1:length(estlambda))+length(estlambda)*((1:length(estlambda))-1));
estlambda(offdiagonals) = estparams(1:num_rates);

estlaplacian = estlambda.*(1-eye(size(estlambda))) - (1-eye(size(estlambda)))*estlambda.*eye(size(estlambda));

dwlsval = fval;

[estparams, fval, exitflag] = ...
    fmincon( @(params)( clsmetric(params, t, meandata, Fl, mL, mu, g, estlambda) ), ...
            rand(2,1), ...
            [], [], ... % inequalities (A*x <= b)
            [], [], ... % equalities (Aeq*x == beq)
            [ 1e-6; 1e-6 ], ... % lower bounds
            [ 0.5; 1 ], ... % upper bounds
            [], ... % non-linear constraint
            optimset('Algorithm', 'active-set', ...
                     'Display', 'iter', ...
                     'FunValCheck', 'on', ...
                     'MaxFunEvals', 1300 ) ...
            );  %#ok<NASGU>

estFpg = estparams(end-1);
estvd = estparams(end);
cwlsval = fval;

estauglaplacian = [ estlaplacian zeros(length(estlambda),2) ;
                    zeros(1,length(estlambda)) 0 1 ;
                    zeros(1,length(estlambda)) 0 0 ];

d = 1;
simtime = linspace(min(t),max(t),length(t)*5);
[~, estmeanfield] = ode23( @(t,meanstate)(estauglaplacian*meanstate ...
                                    + [ zeros(length(estlambda)+1,1) ; estFpg*(estvd - meanstate(end))*meanstate(1)/mL ] ...
                                    - [ zeros(length(estlambda)+1,1) ; d*mu*max(0, g - (Fl/mL)*(meanstate(1)+meanstate(2)) ) ] ), ...
                                    simtime, meandata(:,1) );
estmeanfield = estmeanfield';

countymax = meandata(1,1) + meandata(2,1) + meandata(3,1);

figure(1);
subplot(2,6,[1 2]);
i=1; plot( t, meandata(i,:), '-', simtime, estmeanfield(i,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Front' );
legend('Sampled', 'Predicted', 'Location', 'NorthWest');

subplot(2,6,[3 4]);
i=2; plot( t, meandata(i,:), '-', simtime, estmeanfield(i,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Back' );
legend('Sampled', 'Predicted', 'Location', 'NorthEast');

subplot(2,6,[5 6]);
i=3; plot( t, meandata(i,:), '-', simtime, estmeanfield(i,:), '--' )
ylim([0 countymax])
xlabel( 'Time (sec)');
ylabel( '# Detached' );
legend('Sampled', 'Predicted');

subplot(2,6,[7 8 9]);
i=4; plot( t, meandata(i,:), '-', simtime, estmeanfield(i,:), '--' )
ylims = ylim;
ylim([0 max(ylims)]);
xlabel( 'Time (sec)');
ylabel( 'Position (cm)' );
legend('Sampled', 'Predicted', 'Location', 'NorthWest');

subplot(2,6,[10 11 12]);
i=5; plot( t, meandata(i,:), '-', simtime, estmeanfield(i,:), '--' )
ylims = ylim;
ylim([0 max(ylims)]);
xlabel( 'Time (sec)');
ylabel( 'Velocity (cm/sec)' );
legend('Sampled', 'Predicted', 'Location', 'NorthWest');

end

%% Helpers

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
    weights = 1./var(meandata, [], 2);
    %weights = [1 1 1];
    for i = 2:length(t)
        error = meanfield(:,i) - meandata(:,i);
        lssum = lssum + error'*diag(weights)*error;
    end

end

function lssum = clsmetric( params, t, meandata, Fl, mL, mu, g, lambda )
    % This maps the number of elements in lambdavec to the number of states
    Fpg = params(end-1);
    vd = params(end);

    laplacian = lambda.*(1-eye(size(lambda))) - (1-eye(size(lambda)))*lambda.*eye(size(lambda));

    auglaplacian = [ laplacian zeros(length(lambda),2) ;
                     zeros(1,length(lambda)) 0 1 ;
                     zeros(1,length(lambda)) 0 0 ];

    d = 1;
    [~, meanfield] = ode15s( @(t,meanstate)(auglaplacian*meanstate ...
                                        + [ zeros(length(lambda)+1,1) ; Fpg*(vd - meanstate(end))*meanstate(1)/mL ] ...
                                        - [ zeros(length(lambda)+1,1) ; d*mu*max(0, g - (Fl/mL)*(meanstate(1)+meanstate(2)) ) ] ), ...
                                        t, meandata(:,1) );
    meanfield = meanfield';

    % This sums up the squared differences over time
    lssum = 0;
    weights = 1./var(meandata((end-1):end,:),[],2);
    %weights = [1 5];
    for i = 2:length(t)
        error = meanfield((end-1):end,i) - meandata((end-1):end,i);
        lssum = lssum + error'*diag(weights)*error;
    end

end

%#ok<*MFAMB>