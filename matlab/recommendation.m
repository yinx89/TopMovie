function recommendation(id_user)

% Cargamos datos
[Y, R, movieList] = getData();

%  Valores utiles
num_users = size(Y, 2);
num_movies = size(Y, 1);
num_features = 10;
my_ratings = Y(:,id_user);

% Inicializa parámetros (Theta, X)
X = randn(num_movies, num_features);
Theta = randn(num_users, num_features);

initial_parameters = [X(:); Theta(:)];

% Selecciona las opciones de fmincg
options = optimset('GradObj', 'on', 'MaxIter', 100);

% Ajusta regularización y ejecuta la optimización
lambda = 3;
theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
                                num_features, lambda)), ...
                initial_parameters, options);

% Extrae X y Theta del vector resultante de la optimización (theta)
X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(theta(num_movies*num_features+1:end), ...
                num_users, num_features);


%% ================== Generando recomendaciones ====================
%  Tras entrenar el algoritmo podemos realizar recomendaciones a partir de
%  la matriz de puntuaciones generada

p = X * Theta';
my_predictions = p(:,1).*(my_ratings == 0);
updateRecommendation(my_predictions,id_user);

end