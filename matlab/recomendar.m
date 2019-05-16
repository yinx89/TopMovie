function recomendar(user_id)

[Y, R, movieList] =  getData();

num_users = size(Y,2);
num_movies = size(Y,1);
num_features = 10;

X = randn(num_movies, num_features);
Theta = randn(num_users, num_features);

initial_parameters = [X(:); Theta(:)];

options = optimset('GradObj', 'on', 'MaxIter', 100);

lambda = 10;
theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
                                num_features, lambda)), ...
                initial_parameters, options);

X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(theta(num_movies*num_features+1:end), ...
                num_users, num_features);

p = X * Theta';

my_predictions = p(:,user_id);

updateRecommendation(my_predictions, user_id);

end