# manage
WayTab's remote management suite

### Setting up local dev server
Included is a Vagrantfile for a local Apache/PHP/MySQL dev server.  
```bash
vagrant up
```  
You'll also need to set up the database and a user
```bash
# ssh into the vagrant box
$ vagrant ssh

# boot up a mysql prompt (the server is already running)
$ sudo mysql -u root 


mysql> CREATE DATABASE waytab;  
mysql> USE waytab;  
mysql> source /vagrant/waytab.sql  
mysql> INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `login`, `password`, `password-sha512`) VALUES (NULL, 'Test', 'User', 'user@test.com', '', '', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86');  
mysql> exit  
```

You'll be able to log in to Manage using `user@test.com` and `password`

### Access your dev server in your browser
http://localhost:8080/
