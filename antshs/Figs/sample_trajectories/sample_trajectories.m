load sample_trajectories

trajs = { '3', '4', '5', '13' };
for i = 1:length(trajs)
    eval( sprintf( 'xp%s_X = xp%s_X(isfinite(xp%s_X));', trajs{i}, trajs{i}, trajs{i} ) );
    eval( sprintf( 'xp%s_Y = xp%s_Y(isfinite(xp%s_Y));', trajs{i}, trajs{i}, trajs{i} ) );
    %
    eval( sprintf( 'xp%s_X = xp%s_X - xp%s_X(1);', trajs{i}, trajs{i}, trajs{i} ) );
    eval( sprintf( 'if xp%s_Y(1) < xp%s_Y(end); xp%s_Y = xp%s_Y - xp%s_Y(1); else xp%s_Y = xp%s_Y - xp%s_Y(end); end', trajs{i}, trajs{i}, trajs{i}, trajs{i}, trajs{i}, trajs{i}, trajs{i}, trajs{i} ) );
    %
    fid = fopen( sprintf('sample_trajectory_%s.txt', trajs{i}), 'w' );
    fprintf( fid, '%0.4f %0.4f\n', eval(sprintf('[xp%s_X xp%s_Y]''', trajs{i}, trajs{i})) );
    fclose(fid);
    %
    eval( sprintf( 'xp%s_t = 5*((1:length(xp%s_X)) - 1)'';', trajs{i}, trajs{i} ) );
    %
    eval(sprintf( 'xp%s_trajdist = [0 cumsum(sqrt(sum((diff([ xp%s_X xp%s_Y ]).^2)'')))]'';', trajs{i}, trajs{i}, trajs{i} ))
    eval(sprintf( 'xp%s_dist = sqrt(sum([ xp%s_X xp%s_Y ].^2''))'';', trajs{i}, trajs{i}, trajs{i} ))
    %
    fid = fopen( sprintf('sample_trajectory_%s_dist.txt', trajs{i}), 'w' );
    fprintf( fid, '%0.4f %0.4f\n', eval(sprintf('[xp%s_t xp%s_dist]''', trajs{i}, trajs{i})) );
    fclose(fid);
    %
    fid = fopen( sprintf('sample_trajectory_%s_trajdist.txt', trajs{i}), 'w' );
    fprintf( fid, '%0.4f %0.4f\n', eval(sprintf('[xp%s_t xp%s_trajdist]''', trajs{i}, trajs{i})) );
    fclose(fid);
end

