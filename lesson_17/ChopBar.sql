CREATE DATABASE chopbar;

SHOW DATABASES;

USE chopbar;

Create database if not exists chopbar;

Create Table menu (
    item_id int primary key auto_increment,
    name varchar(49),
    category char(5),
    code binary(3),
    price decimal(5,2),
    description text,
    photo BLOB,
);

insert into menu(name, category, code, price, added_on, description) Values
('Jollof Rice', 'food', 'JR1', 35.00, CURDATE(), 'Spicy tomato rice cooked with peppers and served hot'),
('Waakye', 'food',  'WK1', 30.00, CURDATE(), 'Rice and beans with stew, egg and gari'),
('Kelewele', 'food',  'KL1', 25.00, CURDATE(), 'Fried ripe plantain cubes spiced with ginger and pepper'),
('Sobolo', 'drink', 'SB1', 10.00, CURDATE(), 'Chilled hibiscus drink flavoured with ginger and cloves');

select * from menu;

select * from menu where name = 'jollof rice';
select * from menu where code = 'jr1';

Create index idx_name on menu (name);
create fulltext index idx_description on menu (description);

select name from menu where match(description) AGAINST('ginger');


Create table orders (
    order_id int unsigned AUTO_INCREMENT primary key,
    customer varchar(32),
    item_id int unsigned,
    qty int,
    index idx_customer (customer),
);

insert into orders (customer, item_id, qty) VALUES
    ('Ama', 1, 2),
    ('Ama', 4, 3),
    ('Kofi', 2, 1);

Select * from orders;

Select ustomer, name, qty
from orders natural join menu;

/* Natural Join doesn't need ON because it automatically joins the two tables on every column that has the same name in both tables.
*/

select o.customer as customer,
    m.name as dish,
    o.qty as quantity
from orders as o
join menu as m on o.item_id = m.item_id;

Select o.customer as customer,
    m.name as dish,
    o.qty as quantity,
    m.price as price
from orders as o
join menu as m on o.item_id =m.item_id
    and o.qty > 1
    and m.price < 40;