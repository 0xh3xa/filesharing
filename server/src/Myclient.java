
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Myclient {
public static void main(String[] args) {
   int id =2;
   String filename="ahmed";
   
   
   
    try {
        Socket s=new Socket("127.0.0.1",4321);
        System.out.println("connected");
        InputStream in=s.getInputStream();
        OutputStream out=s.getOutputStream();
        DataInputStream input=new DataInputStream(in);
        DataOutputStream output=new DataOutputStream(out);
        output.writeInt(id);
        output.writeUTF(filename);
        output.flush();
        input.close();
        s.close();
        
    } catch (IOException ex) {
        ex.getMessage();
    }
}
    
}
