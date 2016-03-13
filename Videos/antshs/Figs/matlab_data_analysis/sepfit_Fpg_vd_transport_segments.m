function [estFpgall, estvdall, wlsvalall, estFpg, estvd, wlsval] = sepfit_Fpg_vd_transport_segments
% SEPFIT_FPG_VD_TRANSPORT_SEGMENTS   Fit (Fpg, vd) to Aurelie's data.

% [estFpgall, estvdall, wlsvalall, estFpg, estvd, wlsval] = sepfit_Fpg_vd_transport_segments;

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
% detached_ants = repmat( max( front_ants + back_ants ), size(front_ants,1), 1 ) - (front_ants + back_ants);

num_replicates = size(front_ants,1);

% Upper bound on estFpg
gain_ub = 10;

fprintf( '[*] Starting fitting process for all segments combined...\n' );

[estparams, fval, exitflag] = ...
    fmincon( @(params)( allsegslsmetric(params, t, x, v, front_ants, back_ants, Fl, mL, mu, g) ), ...
            rand(2,1), ...
            [], [], ... % inequalities (A*x <= b)
            [], [], ... % equalities (Aeq*x == beq)
            [ 1e-6; 1e-6 ], ... % lower bounds
            [ gain_ub; 2 ], ... % upper bounds
            [], ... % non-linear constraint
            optimset('Algorithm', 'active-set', ...
                     'Display', 'iter', ...   % 'iter' or 'final'
                     'FunValCheck', 'on', ...
                     'MaxFunEvals', 1300 ) ...
            );  %#ok<NASGU>

estFpgall = estparams(end-1);
estvdall = estparams(end);
wlsvalall = fval;
fprintf( '     [*] Estimates for all segments: estFpg = %0.4f, estvd = %0.4f, WLS = %0.4f\n\n', estFpgall, estvdall, wlsvalall );

estFpg = zeros(num_replicates, 1);
estvd = zeros(num_replicates, 1);
wlsval = zeros(num_replicates, 1);
for replicate=1:num_replicates
    fprintf( '[*] Starting replicate %d fitting process...\n', replicate );
    [estparams, fval, exitflag] = ...
        fmincon( @(params)( seglsmetric(params, t, x(replicate,:), v(replicate,:), front_ants(replicate,:), back_ants(replicate,:), Fl, mL, mu, g) ), ...
                rand(2,1), ...
                [], [], ... % inequalities (A*x <= b)
                [], [], ... % equalities (Aeq*x == beq)
                [ 1e-6; 1e-6 ], ... % lower bounds
                [ gain_ub; 2 ], ... % upper bounds
                [], ... % non-linear constraint
                optimset('Algorithm', 'active-set', ...
                         'Display', 'final', ...   % 'iter' or 'final'
                         'FunValCheck', 'on', ...
                         'MaxFunEvals', 1300 ) ...
                );  %#ok<NASGU>

    estFpg(replicate) = estparams(end-1);
    estvd(replicate) = estparams(end);
    wlsval(replicate) = fval;

    fprintf( '     [*] Replicate %d, estFpg = %0.4f, estvd = %0.4f, WLS = %0.4f\n\n', replicate, estFpg(replicate), estvd(replicate), wlsval(replicate) );
%     
%     [~, estctsstate] = ode15s( @(tau,ctsstate)( segment_field( tau, ctsstate, estFpg, estvd, i, front_ants, back_ants, t, Fl, mL, mu, g ) ), ...
%                                         t, [ x(i,1); v(i,1) ] );
% 
%     estctsstate = estctsstate';
%     
%     estFpg
%     estvd
% 
%     figure(1);
%     subplot(2,2,1);
%     plot( t, front_ants(i,:), '-' )
%     xlabel( 'Time (sec)');
%     ylabel( '# Front' );
%     legend('Sampled', 'Location', 'NorthWest');
% 
%     subplot(2,2,2);
%     plot( t, back_ants(i,:), '-' )
%     xlabel( 'Time (sec)');
%     ylabel( '# Back' );
%     legend('Sampled', 'Location', 'SouthEast');
% 
%     subplot(2,2,3);
%     plot( t, x(i,:), '-', t, estctsstate(1,:), '--' )
%     xlabel( 'Time (sec)');
%     ylabel( 'Position (cm)' );
%     legend('Sampled', 'Predicted', 'Location', 'NorthWest');
% 
%     subplot(2,2,3);
%     plot( t, v(i,:), '-', t, estctsstate(2,:), '--' )
%     xlabel( 'Time (sec)');
%     ylabel( 'Velocity (cm/sec)' );
%     legend('Sampled', 'Predicted', 'Location', 'NorthWest');
%
%     pause;
end

end

%% Helpers

function [field] = segment_field( tau, ctsstate, Fpg, vd, replicate, front_ants, back_ants, t, Fl, mL, mu, g )
%    [~, ti] = min( abs(t-tau) );
%    ti = nnz( tau <= t );
%    ti = (t == tau);
    ti = find( tau >= t, 1, 'last' );

    %d = sign(ctsstate(2));
    d = 1;
    field = [0 1; 0 0]*ctsstate ...
            + [0; Fpg*(vd - ctsstate(2))*front_ants(replicate,ti)/mL ] ...
            - [0; d*mu*max(0, g - (Fl/mL)*(front_ants(replicate,ti)+back_ants(replicate,ti)) ) ];

end

function lssum = seglsmetric( params, t, x, v, num_front, num_back, Fl, mL, mu, g )
    % This maps the number of elements in lambdavec to the number of states
    Fpg = params(end-1);
    vd = params(end);

    [~, ctsstate] = ode15s( @(tau,ctsstate)( segment_field( tau, ctsstate, Fpg, vd, 1, num_front, num_back, t, Fl, mL, mu, g ) ), ...
                                        t, [ x(1); v(1) ] );
    ctsstate = ctsstate';

    % This sums up the squared differences over time
    lssum = 0;
    weights = 1./var([x; v], [], 2);
    %weights = [1 5];
    for i = 2:length(t)
        error = ctsstate((end-1):end,i) - [ x(i); v(i) ];
        lssum = lssum + error'*diag(weights)*error;
    end

end

function lssum = allsegslsmetric( params, t, x, v, front_ants, back_ants, Fl, mL, mu, g )
    % This maps the number of elements in lambdavec to the number of states
    Fpg = params(end-1);
    vd = params(end);

    lssum = 0;

    for replicate = 1:size(x, 1)
        [~, ctsstate] = ode15s( @(tau,ctsstate)( segment_field( tau, ctsstate, Fpg, vd, 1, front_ants(replicate,:), back_ants(replicate,:), t, Fl, mL, mu, g ) ), ...
                                            t, [ x(replicate,1); v(replicate,1) ] );
        ctsstate = ctsstate';

        weights = 1./var([x(replicate,:); v(replicate,:)], [], 2);
        %weights = [1 5];
        for i = 2:length(t)
            error = ctsstate((end-1):end,i) - [ x(replicate,i); v(replicate,i) ];
            lssum = lssum + error'*diag(weights)*error;
        end
    end

end

%#ok<*MFAMB>