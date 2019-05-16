# TopMovie

![Screenshot](img/1.png) 

## Table of Contents

1. [Introduction](#Introduccion)  
1.1. [Application Access URL](#URLAcceso)  
2.	[Application logic](#Logica)  
2.1.	[Home page (index.html)](#index)    
2.2.	[Function “registro.php”](#registro)  
2.3.	[Function “login.php”](#login)  
2.4.	[Catalogue (catalogo.php)](#catalogo)  
2.5.	[Function “tablaPeliculas.php”](#tablaPeliculas)  
2.6.	[Movie Information (película.php)](#pelicula)  
2.7.	[Function “valorar.php”](#valorar)  
2.8.	[Function “comentar.php”](#comentar)  
2.9.	[User Information (usuario.php)](#usuario)  
2.10.	[Function “modificar_datos.php”](#modificar_datos)  
2.11.	[Recommendations (Recomendacion.php)](#Recomendacion)  
2.12.	[Format and style](#formato)  
2.13.	[Generic Functions](#genericas)  
3.	[Database design](#bbdd)  
4.	[Algorithm, Interface, and MATLAB Functions](#algoritmo)  
5.	[Additional functionalities implemented](#adicionales)  
5.1.	[Catalog Sorting by Premiere Date](#ordenacion)  
5.2.	[User statistics](#estadisticas)  
5.3.	[Javascript & Ajax](#ajax)  
6.	[Framework: Foundation](#foundation)  
7.	[Annexes](#anexos)  
7.1.	[Annex 1 – List of php functions implemented](#anexo1)  
7.2.	[Annex 2 – Organizational structure of archives](#anexo2)  
8.	[References](#referencias)  


<a name="Introduccion"/>

### 1.	Introduction  

The "TopMovie" application has been developed in order to offer the user an information service on a film catalogue. The user interaction with the application will generate at the same time recommendations based on the algorithm of collaborative filtering through a voting system, in addition to the possibility of writing comments or reviews on the film.  

The development of the application logic could be summarized in the use of functions that aim to offer the user each of the needs required for its proper functioning.   

<a name="URLAcceso"/>

### 1.1	Application Access URL	  

En primer lugar, la aplicación web está almacenada en el servidor del laboratorio de prácticas de la asignatura y el acceso a la aplicación se realiza a través del siguiente enlace:  
http://labit601.upct.es/~ai6/videoGMA  
  
<a name="Logica"/>

### 2.	Application logic 

Then, each of the functionalities is developed in detail and the solution is justified.

<a name="index"/>

### 2.1	Home page (index.html)

Accessing the web application displays the home page (index.html) where the user can register, if not previously done, and log in. The registration method has been carried out with a form in which user data is collected and that through the method "POST" are passed to "registro.php" and ready to be inserted into the database. The login method is done through "login.php" by means of cookies with a fixed duration of 1800 seconds.   
  
![Screenshot](img/2.png) 

<a name="registro"/>  

### 2.2	Function “registro.php”  

In this function the connection to the database is established and the data of $_POST is collected for its insertion in the database.  

![Screenshot](img/3.png) 
   
Note that the is_uploaded_file() function is used to check whether the registration form has correctly saved the user image so that it is later moved to the folder created in the directory with the name "/img".  
  
![Screenshot](img/4.png)   
  
![Screenshot](img/5.png)   
   
The permissions of the /img folder had to be modified so that the image associated with each user could be saved by adding writing permissions for all users.  
  
<a name="login"/>  

### 2.3	Function “login.php”  

This other function basically checks whether the data that has been entered and saved in a cookie matches any of the users of the database and thus gives access to the catalog view.   
  
![Screenshot](img/6.png)   
   
<a name="catalogo"/>  

### 2.4	Catalogue (catalogo.php)  
  
Once you have logged in, you can access the "catalogo.php" view where information about each of the films is displayed in a table with the possibility of sorting it: by default, in alphabetical order, by premiere date or by weighted score. The table shows up to 10 movies per page with the ability to navigate between them with two control buttons at the bottom.      
  
![Screenshot](img/7.png)     
    
First it checks if the time limit marked in the cookie has been exceeded and sends an alert message if so forcing the user to re-enter their credentials. Next it shows the table ordered "by default" through peticionAjax.js with the function "enviar()" in which it is passed as parameters the type of order that will follow the table and the page in which it is to facilitate navigation between them with the two lower buttons.  
   
<a name="tablaPeliculas"/>  

### 2.5	Function “tablaPeliculas.php”  

This function is called from peticionAjax.js with a certain filter with which it will sort the table and the page in which it is located.  
  
![Screenshot](img/8.png)   
   
Its operation is based on making the appropriate queries to sort and display the table according to the selected option. The common code has been eliminated from the "case" filters, making it the same for any type of sorting. This portion of the code performs the appropriate database queries to obtain for each film its average, the total votes and the weighted average as shown below.    
  
![Screenshot](img/9.png)   
  
It should be noted that in the visualization of the table it has been decided to reduce the response time in the calculation of the total average of the films in the catalogue, necessary to calculate the weighted average, with the insertion of a new table in the database that will later be explained. In this way the visualization will be instantaneous without forgetting that this total average of movies will change with each new vote.     
  
<a name="pelicula"/>  

### 2.6	Movie Information (pelicula.php)  

Once a film has been selected, the "pelicula.php" view is accessed and detailed information is shown with the title, release date, link to IMDB, general ratings, as well as the possibility of rating, commenting and viewing all comments on the film.    
  
![Screenshot](img/10.png)   
  
<a name="valorar"/>  

### 2.7	Function “valorar.php”  

As previously mentioned, once the film is evaluated, a new value must be established as the total average of the films, as well as updating the average and weighted value of the voted film. In this way, each time the user votes, in the background the data of the film average and the total average of the films are updated, which is considered necessary to have an updated and real weighted average in each visualization.  
  
![Screenshot](img/11.png)   
  
<a name="comentar"/>   

### 2.8	Function “comentar.php”   
  
The function simply collects data from the form and inserts it into the database.    
  
<a name="usuario"/>  

### 2.9	User Information (usuario.php)  

It is accessed from the header section at the top right and first displays the user data along with profile image and offers the possibility to modify personal data and password. Secondly, it shows a series of statistics to serve as an evaluation since it is understood that the user can change his opinion about a film and in this way he would have a global vision of all the commented and voted films and be able to modify a vote carried out or insert new comments. Finally, there is the possibility of generating a personalised list of recommendations, as described in section 2.5.
   
![Screenshot](img/12.png)   
  
<a name="modificar_datos"/>   

### 2.10	Function “modificar_datos.php”  

The database is updated with the inserted values.  
  
<a name="Recomendacion"/>  

### 2.11	Recommendations (Recomendacion.php)  

It is accessed from the header section and displays a table with the information of the 10 highest scoring movies generated by the collaborative filtering algorithm taking into account user interests and similar user profiles. In order to generate the recommendations, a button located at the top of the screen must be pressed and the algorithm will work in the background on the server so that, after a processing time in which the user can continue browsing the web, a new personalized recommendation will be shown in this section.  
  
![Screenshot](img/13.png)   
   
<a name="formato"/>   

### 2.12	Format and style  

Once the application logic has been completed, each "view" or section is formatted and styled. Each section has in common with the rest the header and footer sections. The framework "Foundation" is used as it will be detailed later because it does a good job with CSS classes, for its ease of use and because the final appearance of the web application besides its adaptability is remarkable.     

In addition to the framework, several CSS style sheets are used for each section where it was necessary to change an element in question for aesthetics and adaptability with the rest of the elements.  
  
<a name="genericas"/>   

### 2.13	Generic Functions   
  
In each section, generic functions have been used to facilitate the implementation of sections such as the header and footer in each of them. In addition, the generic function responsible for connecting to the database has been carried out.   
  
On the other hand, common CSS style sheets are used for a standard view of each element in addition to Javascript functions.
    
<a name="bbdd"/> 

### 3.	Database design  

Starting from the initial structure of the database, a number of changes are made.   

The first is the insertion of a new table called "media" which aims to offer simplicity when sorting films by weighted score. The table would look like this:  
  
![Screenshot](img/14.PNG)   
  
Second, a new table called "valores" is added, which stores an average value of all movies based on calculations that affect the total average of movies that changes each time a user adds a new vote on a movie and changes its value. Two other values it stores are "id_user", to be used as a primary key, and a TIMESTAMP type "time" value which has the purpose of saving the last modification on the average value of the total of films and in this way simplifying the visualization of the score values without having to recalculate this value. The table would look like this:  
  
![Screenshot](img/15.PNG)   
  
In this way, with each vote, a change of values affecting the weighted average of each film takes place in the background. In this way, this last table will store a single row with an average value of the total of the films according to a time value. If when the voting is carried out, there is a previous temporary value, it is eliminated and a new average value is inserted so that, in each visualization, the updated value can be shown without waiting time for its calculation.  
  
![Screenshot](img/16.png) 
   
<a name="algoritmo"/>  

### 4.	Algorithm, Interface, and MATLAB Functions  

The algorithm in charge of generating recommendations is collaborative filtering through the two getData() and updateRecommendation() files located in the /matlab folder of the web directory. Once the "Generate recommendation" button is clicked, the dorec.php function is called, which commands the recommendation() file to be executed, passing the user's identifier as an argument. Once it is executed, the Recommendation section will show a list of 10 movies recommended according to this algorithm. It is worth mentioning that the algorithm runs in the background with the following lines of code, so while you can browse the rest of the web, but the recommendation is not instantaneous.  
  
![Screenshot](img/17.png)   
   
<a name="adicionales"/>   

### 5.	Additional functionalities implemented   
   
<a name="ordenacion"/>  

### 5.1	Catalog Sorting by Premiere Date   

One of the extra functionalities is the sorting by release date implemented in the table tablaPeliculas.php in the following way:  
  
![Screenshot](img/18.png)   
  
<a name="estadisticas"/>   

### 5.2	User statistics   

Another of the extra functionalities implemented is the display of a series of statistics in the "user" section such as published comments, published scores and recommendations.  
    
![Screenshot](img/19.png)   
   
![Screenshot](img/20.png)   
   
<a name="ajax"/>  

### 5.3	Javascript & Ajax  

Ajax has served to dynamically display the table according to its order and its use has made it easier to navigate through the catalog in pages with the enviar() function.  
  
The search engine is also part of Ajax. In this way you get a search result with a dropdown as you type characters using the buscar() function. In order to carry out this section, it has been necessary to consult references that are described in section 8.  
  
<a name="foundation"/>   

### 6.	Framework: Foundation  
  
The use of a predefined frame helps to have an aesthetic and structural basis of the layout, therefore the front-end use of "Foundation" in this project is oriented above all to solve the problems before the use and view of the user. It is also a solution to the problems of browser incompatibility and thus, the logic is not tarnished by a bad user experience in navigation. Not all the capacities provided by the framework have been squeezed but it complies with the requirements considered necessary for the correct execution of the application, in addition to solving the problem of the style and format of the page with CSS style sheets applying a common model.  
  
![Screenshot](img/21.jpg)   
  
<a name="anexos"/>   

### 7.	Annexes  
  
<a name="anexo1"/>  

### 7.1	Annex 1 – List of php functions implemented  
  
buscar.php  
cabecera.php  
catalogo.php  
cerrar_sesion.php  
comentar.php  
conexión.php  
dorec.php  
login.php  
modificar_datos.php  
película.php  
pie.php  
Recomendación.php  
registro.php  
tablaPeliculas.php  
update_user.php  
usuario.php  
valorar.php  
  
<a name="anexo2"/>   

### 7.2	Annex 2 – Organizational structure of archives  
  
![Screenshot](img/22.png)   
  
/ai6 – Directory where the mysql-connector-java-5.1.38-bin connector is located.  
/css – Directory where the different style sheets are stored and the folder where the background images are stored.  
/images – Directory where the different covers of movies are hosted.  
/img – Directory where the different images of the users are stored.  
/js – Directory where the different Javascript files are stored.  
/matlab – Directory where the different Matlab files necessary for the execution of the recommendation algorithm are hosted.  
  
<a name="referencias"/>   

### 8.	References   
  
How PHP works - http://php.net/manual/es/  
Choice of framework – https://carlosazaustre.es/blog/frameworks-de-javascript/  
Use of Foundation - http://cubemedia.co/responsive-instalando-foundation-css/  
Onkeyup search - http://www.w3schools.com/ajax/ajax_php.asp  
Dropdown in Foundation  - http://foundation.zurb.com/sites/docs/v/5.5.3/components/dropdown.html  
Frameworks - http://www.awwwards.com/what-are-frameworks-22-best-responsive-css-frameworks-for-web-design.html  
