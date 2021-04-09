# PHPMikAPISQL Class v0.1
 
Simple class to execute RouterOS Command like SQL (select, insert, update, delete)  
Dependend to **routeros_api.class.php** (https://github.com/BenMenking/routeros-api)  
Simply you may just change the table name with router's menu (see ``table-list.ini`` in db folder)  

## SQL Command List

* SELECT  
Retrieves data from the router. for example if you want to print router's interface list you can use ``"select * from interface"``. this command can be only combined with the simple search clause ``where`` or/and sorting using ``order by .id asc`` or ``order by .id desc``. 

* INSERT  
Add config item to the router. for example if you want to add user to the router you can use ``insert into user (name,group) values ('budi','full')``. just change the table's field using menu's property.     
  
* UPDATE  
Update router config item. for example if you want to edit user from the router you can use ``update user set group='read' where .id='*2'``. similar to insert command, the table's field is menu's property. 

* DELETE  
Remove config item from the router. for example if you want to remove user from the router you can use ``delete from user where .id='*2'``.  

### Conclusion  
The table name is refers to router's menu where stored in ``db/table-list.ini``. just add it manually if it not listed.  
The table's field is refers to property of router's menu. you can see the output of the ``SELECT`` command where the keys in the array are what I mean.  
 