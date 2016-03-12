% uncorrelated_v_and_Nf   Plot E(v)*E(Nf) and E(v*Nf) for Aurelie's data.

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

%% Plot
plot( t, mean(front_ants).*mean(v), '--', t, mean(front_ants.*v), '.-' );
xlabel( 'Time (s)' );
ylabel( '(ant-cm/s)' );
legend( 'E(N_F)E(v)', 'E(N_Fv)', 'Location', 'NorthWest' );

%% Output to files for LaTeX
fid = fopen( 'uncorrelated_v_and_Nf_ENfEv.txt', 'w' );
fprintf( fid, '%0.4f %0.4f\n', [t; mean(front_ants).*mean(v)] );
fclose(fid);

fid = fopen( 'uncorrelated_v_and_Nf_ENfv.txt', 'w' );
fprintf( fid, '%0.4f %0.4f\n', [t; mean(front_ants.*v)] );
fclose(fid);