lambda = [0, 0.03, 0.1, 1, 3, 10, 30, 100];
fprintf('Cargamos el dataset.\n\n');
%  Load data
load ('ex2_movies.mat'); %Carga R e Y 
%  Valores utiles
num_users = size(Y, 2);
num_movies = size(Y, 1);
num_features = 100;

Rtrain=R;
Rtest=zeros(size(R));
filas = []; columnas =[];
for i=1:(0.1*size(Y,1)) 
    f=round(size(Y,1)*rand);    
    filas(end+1)=f;   
end    
for i=1:(0.1*size(Y,2))
    c=round(size(Y,2)*rand);
    columnas(end+1)=c;
end
Rtrain(filas,columnas)=0; 
Rtest(filas,columnas)=R(filas,columnas);
    C=sum(Rtest(:));
Ytrain = Y.*Rtrain;
Ytest = Y.*Rtest;
RMSE = zeros(length(lambda));
for j=1:length(lambda)
   % Inicializa parámetros (Theta, X)
    X = randn(num_movies, num_features);
    Theta = randn(num_users, num_features);

    initial_parameters = [X(:); Theta(:)];

    % Selecciona las opciones de fmincg
    options = optimset('GradObj', 'on', 'MaxIter', 100);

    % Ajusta regularización y ejecuta la optimización
    lam = lambda(j);
    theta = fmincg (@(t)(cofiCostFunc(t, Ytrain, Rtrain, num_users, num_movies, ...
                                    num_features, lam)), ...
                    initial_parameters, options);

    % Extrae X y Theta del vector resultante de la optimización (theta)
    X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
    Theta = reshape(theta(num_movies*num_features+1:end), ...
                    num_users, num_features);

    Ypred = X*Theta'.*Rtest;
    a = (((Y-Ypred).*Rtest).^2);
    RMSE(1)=sqrt(sum(a(:))/C);
   
end
    plot(RMSE)