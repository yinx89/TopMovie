%% Aplicaciones en Internet
%  Filtrado Colaborativo para Recomendación
%
%  Instrucciones
%  ------------
%
%  Este fichero contiene codigo que te ayudará a ir realizando la 
%  practica. En ella debes modificar la siguiente función :
%
%     cofiCostFunc.m
%
%  En esta práctica no debes modificar este fichero, excepto en la Parte 6,
%  en la que introduciras las peliculas y las puntuaciones que desees.
%

%% =============== Parte 1: Cargar dataset ================
%  Comenzaremos cargando el dataset de películas para entender la estructura
%  de los datos.
%  
fprintf('Cargamos el dataset.\n\n');

%  Load data
load ('ex2_movies.mat');

%  Y es una matriz de 1682x943, que contiene las puntuaciones (1-5) de 1682
%  peliculas por parte de 943 usuarios
%
%  R es una matriz de 1682x943, donde R(i,j) = 1 si y solo si el usuario j ha 
%  puntuado la pelicula i

%  A partir de la matriz podemos calcular las puntuaciones medias de cada película.
fprintf('Puntuación media para la película 1 (Toy Story): %f / 5\n\n', ...
        mean(Y(1, R(1, :))));

%  Podemos "visualizar" la matriz de punutaciones imprimiendola con imagesc
imagesc(Y);
ylabel('Movies');
xlabel('Users');

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;

%% ============ Parte 2: Funcion de coste de filtrado colaborativo ===========
%  Aquí se comprueba el resultado obtenido en la función de coste
%  (sin regularización) implementada. Es decir el valor de J devuelto por
%   cofiCostFunc.m. Para hacer la comprobación hemos incluido los
%   parámetros ya precalculados


%  Cargamos los parámteros precalculados (X, Theta, num_users, num_movies, num_features)
load ('ex2_movieParams.mat');

%  Reducimos el dataset para que se ejecute más rápido
num_users = 4; num_movies = 5; num_features = 3;
X = X(1:num_movies, 1:num_features);
Theta = Theta(1:num_users, 1:num_features);
Y = Y(1:num_movies, 1:num_users);
R = R(1:num_movies, 1:num_users);

%  Evaluamos la función de coste
J = cofiCostFunc([X(:) ; Theta(:)], Y, R, num_users, num_movies, ...
               num_features, 0);
           
fprintf(['Coste obtenido: %f '...
         '\n(este valor debería ser 22.22)\n'], J);

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;


%% ============== Parte 3: Gradiente del filtrado colaborativo ==============
% Cuando el coste obtenido coincida con el esperado, vamos a comprobar el
% gradiente, es decir, el valor de grad dado por tu función cofiCostFunc.m
%  
fprintf('\nComprobando gradientes (sin regularizacion) ... \n');

%  emplea la función checkCostFunction
checkCostFunction;

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;


%% ========= Parte 4: Coste con regularización ========
%  Se va a realizar la comprobación del valor de coste obtenido con
%  regularización.
%  

%  Evaluamos las función de coste
J = cofiCostFunc([X(:) ; Theta(:)], Y, R, num_users, num_movies, ...
               num_features, 1.5);
           
fprintf(['Coste obtenido con regularizacion (lambda = 1.5): %f '...
         '\n(este valor debería estar alrededor de 31.34)\n'], J);

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;


%% ======= Parte 5: Gradiente con regularización ======
%  Se va a realizar la comprobación del gradiente obtenido con
%  regularización.
%

%  
fprintf('\nComprobando gradientes (sin regularizacion) ... \n');

%  emplea la función checkCostFunction
checkCostFunction(1.5);

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;


%% ============== Parte 6: Introducir nuestras puntuaciones ===============
%  Antes de comenzar a entrenar el algoritmo vamos a introducir nuestras
%  propias puntuaciones, para que en la parte final el algoritmo nos
%  muestre recomendaciones adecuadas a nuesrtras preferencias 
%
movieList = loadMovieList();

%  Inicializo mis puntuaciones
my_ratings = zeros(1682, 1);

% =========== A PARTIR DE AQUI PUEDES MODIFICAR LAS PUNTUACIONES ==========
% Consulta en el fichero movie_idx.txt el numero identificativo de cada
% película. Por ejemplo, Toy Story (1995) tiene un id 1, así que para
% puntuarla con un "4$ hay que hacer lo siguiente
my_ratings(1) = 4;

% O imaginate que no te gusto mucho El Silencio de los Corderos (1991),
% puedes darle un "2"
my_ratings(98) = 2;

%Aquí hay una lista de películas de ejemplo. Modifica esta lista
% cambiando películas, puntuaciones y si quieres añade más películas
my_ratings(7) = 3;
my_ratings(12)= 5;
my_ratings(54) = 4;
my_ratings(64)= 5;
my_ratings(66)= 3;
my_ratings(69) = 5;
my_ratings(183) = 4;
my_ratings(226) = 5;
my_ratings(355)= 5;

% ========================================================================= 

fprintf('\n\nNuevas puntuaciones:\n');
for i = 1:length(my_ratings)
    if my_ratings(i) > 0 
        fprintf('Puntuación %d para la película %s\n', my_ratings(i), ...
                 movieList{i});
    end
end

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;


% %% ================== Parte 7: Entrenar el algoritmo ====================
% %  Ahora se entrenará el algortimo de filtrado colaborativo para 
% % 1682 películas y 943 usuarios
% %

fprintf('\nEntrenando el filtrado colaborativo...\n');

%  Cargamos datos
load('ex2_movies.mat');

%  Añade tus puntuaciones a la matriz de datos
Y = [my_ratings Y];
R = [(my_ratings ~= 0) R];

%  Valores utiles
num_users = size(Y, 2);
num_movies = size(Y, 1);
num_features = 10;

% Inicializa parámetros (Theta, X)
X = randn(num_movies, num_features);
Theta = randn(num_users, num_features);

initial_parameters = [X(:); Theta(:)];

% Selecciona las opciones de fmincg
options = optimset('GradObj', 'on', 'MaxIter', 100);

% Ajusta regularización y ejecuta la optimización
lambda = 10;
theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
                                num_features, lambda)), ...
                initial_parameters, options);

% Extrae X y Theta del vector resultante de la optimización (theta)
X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(theta(num_movies*num_features+1:end), ...
                num_users, num_features);

fprintf('Aprendizaje del sistema de recomendación finalizado.\n');

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');
pause;

%% ================== Parte 8: Generando recomendaciones ====================
%  Tras entrenar el algoritmo podemos realizar recomendaciones a partir de
%  la matriz de puntuaciones generada
%

p = X * Theta';
my_predictions = p(:,1).*(my_ratings == 0);

movieList = loadMovieList();

[r, ix] = sort(my_predictions, 'descend');
fprintf('\nTop te recomendamos:\n');
for i=1:10
    j = ix(i);
    fprintf('Puntuacion estimada %.1f para la pelícila %s\n', my_predictions(j), ...
            movieList{j});
end

fprintf('\n\nPuntuaciones originales proporcionadas:\n');
for i = 1:length(my_ratings)
    if my_ratings(i) > 0 
        fprintf('Puntuación %d para %s\n', my_ratings(i), ...
                 movieList{i});
    end
end

%% ================== Parte 9: Ajustando el parámetro de configuración ====================





