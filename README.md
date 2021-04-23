# PHPMikAPISQL Class v0.1
 
Simple class to execute RouterOS Command like SQL (select, insert, update, delete)  
Dependend to **routeros_api.class.php** (https://github.com/BenMenking/routeros-api)  
Simply you may just change the table name with router's menu (see ``table-list.ini`` in db folder)  
The structure of menu is separated by strip (-). for example if you want to access **pool** which is sub from **ip** menu, you can type **ip-pool** as the table name   

## SQL Command List

* SELECT  
Retrieves data from the router. for example if you want to print router's interface list you can use ``"select * from interface"`` or print only specific item ``"select .id,name from interface"``. this command can be combined with the search clause ``where`` or/and sorting using ``order by .id asc`` or ``order by .id desc``. use limit keyword at the last to limit output ``select * from interface limit 2``

* INSERT  
Add config item to the router. for example if you want to add user to the router you can use ``insert into user (name,group) values ('budi','full')``. just change the table's field with menu's attribut.     
  
* UPDATE  
Update router config item. for example if you want to edit user from the router you can use ``update user set group='read' where .id='*2'``. similar to insert command, the table's field is menu's attribut. 

* DELETE  
Remove config item from the router. for example if you want to remove user from the router you can use ``delete from user where .id='*2'``.  

### Conclusion  
The table name is refers to router's menu where stored in ``db/table-list.ini``. just add it manually if it not listed yet.  
The table's field is refers to attribut of router's menu. you can see the output of the ``SELECT`` command where the keys in the array are what i mean.  
 