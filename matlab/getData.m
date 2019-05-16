function [Y, R, movieList] =  getData()
import java.sql.*;
import java.util.*;
import java.*;
import java.Class.*;

javaclasspath('C:\xampp\htdocs\subiragithub\TopMovie\ai6\mysql-connector-java-5.1.38-bin.jar')

%/home/alumnos/ai6/public_html/videoGMA/ai6/mysql-connector-java-5.1.38-bin.jar

url = 'jdbc:mysql://localhost:3306/ai6';
user = 'root';
password = '';
driver = com.mysql.jdbc.Driver;
props = java.util.Properties;
props.setProperty('user', user');
props.setProperty('password', password);
con = driver.connect(url,props);


%Cargamos las peliculas
st = con.createStatement();
rs = st.executeQuery('SELECT title FROM movie');

movieList = cell(1, 1);
i=1;
while rs.next()
    movieList{i}=char(rs.getString(1));
    i=i+1;
end
num_movies=i-1;

try rs.close(); catch, end

try st.close(); catch, end

%Creamos la matrix R vacia, necesitamos saber el numero de usuarios

st = con.createStatement();
rs = st.executeQuery('SELECT COUNT(id) FROM users');

rs.next();
num_users= rs.getInt(1);


try rs.close(); catch, end

try st.close(); catch, end
R=zeros(num_movies,num_users);






%Construimos la matriz Y y la matrix R

Y=zeros(num_movies, num_users);
st = con.createStatement();
rs = st.executeQuery('SELECT id_user, id_movie, score FROM user_score');

while rs.next()
    movid=rs.getInt(2);
    usid=rs.getInt(1);
    Y(movid,usid)=rs.getInt(3);
    R(movid,usid)=1;
end


try rs.close(); catch, end

try st.close(); catch, end

%Cerramos

try con.closeAllStatements(); catch, end
try con.close(); catch, end
end
