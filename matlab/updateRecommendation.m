function num_updated =  updateRecommendation(my_predictions,userid)
import java.sql.*;
import java.util.*;
import java.*;
import java.Class.*;

javaclasspath('C:\xampp\htdocs\subiragithub\TopMovie\ai6\mysql-connector-java-5.1.38-bin.jar')

url = 'jdbc:mysql://localhost:3306/ai6';
user = 'root';
password = '';
driver = com.mysql.jdbc.Driver;
props = java.util.Properties;
props.setProperty('user', user');
props.setProperty('password', password);
con = driver.connect(url,props);


%Preparamos para multiples inserciones
con.setAutoCommit(false);
%Preparamos una consulta parametrizada
query='INSERT INTO recs (user_id, movie_id, rec_score, time) VALUES(?, ?, ?,NOW()) ON DUPLICATE KEY UPDATE  rec_score=VALUES(rec_score)'
st = con.prepareStatement(query);
%Añadimos lotes
for i=1:length(my_predictions)
    st.setInt(1,userid);
    st.setInt(2,i);
    st.setDouble(3,my_predictions(i));
    st.addBatch();
end
%Ejecutamos consulta
num_updated=st.executeBatch()
con.commit();
try st.close(); catch, end

%Cerramos

try con.closeAllStatements(); catch, end
try con.close(); catch, end
end
