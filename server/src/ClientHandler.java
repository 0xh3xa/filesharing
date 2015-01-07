
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

class ClientHandler extends Thread {

    private String path;//path to file
    private Socket socket;//socket of client
    private InputStream in;//inputstream of ntw
    private OutputStream out;//outputstream of ntw

    public ClientHandler(Socket socket) {
        this.socket = socket;
        getUserName();//get username under /home/ and set/home/---/tmp/
    }

    @Override
    public void run() {
        try {
            System.out.println("here");
            in = socket.getInputStream();
            out = socket.getOutputStream();

            String[] string = readMessage().split(",");

            if (string[1].contains("new")) {

                addUser(string[0]);
            } else if (string[1].contains("del")) {

                delFile(string[0], string[2]);
            } else if (string[1].contains("set")) {

                addFile(string[0], string[2], string[3]);
            } else if (string[1].contains("get")) {

                getFile(string[0], string[2]);
            }

        } catch (Exception ex) {
            ex.printStackTrace();
        } finally {
            try {
                in.close();//close inputstream
                out.flush();//flush buffers
                out.close();//close outputstream
                socket.close();//close socket
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }

    }

    private void getUserName() {
        File file = new File("/home/");
        String[] list = file.list();

        path = "/home/" + list[1] + "/tmp/";//get first user in home
        File pub = new File(path);

        if (!pub.exists()) {//check tmp dir if not exit then make it
            pub.mkdir();
        }
    }

    private void addUser(String user) {//add new folder with id user
        File f = new File(path + user);
        if (!f.exists()) {
            f.mkdir();
        }
    }

    private void delFile(String user, String file) {//delete file 

        File f = new File(path + user + "/" + file);
        if (f.exists()) {
            System.out.println("yes");
            f.delete();
        }

    }

    private void addFile(String user, String file, String content) {//add new file 
        try {
            System.out.println(content.length());

            File f = new File(path + user + "/" + file);
           
                f.createNewFile();
                System.out.println(f.getPath());

                FileOutputStream fos = new FileOutputStream(f);
                fos.write(content.getBytes(), 0, content.getBytes().length);
                fos.flush();
                fos.close();
            
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
    }

    private void getFile(String user, String file) {//read file
        try {

            File f = new File(path + user + "/" + file);

            if (f.exists()) {

                FileInputStream fis = new FileInputStream(f);

                byte[] buffer = new byte[10];
                int len = 0;

                while ((len = fis.read(buffer)) != -1) {
                    out.write(buffer, 0, len);
                    out.flush();

                }
                fis.close();
                out.close();

            }
        } catch (Exception e) {
        }
    }

    private String readMessage() {

        try {

            byte[] buffer = new byte[5];//buffer of size kb
            int len = 0;
            String string = "";
            while ((len = in.read(buffer)) != -1) {
                string += new String(buffer);
                if (string.contains("end")) {
                    break;
                }
            }

            return string;
        } catch (IOException ex) {
            ex.printStackTrace();
        }
        return null;
    }
}
