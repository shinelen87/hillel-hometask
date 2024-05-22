-- Видалення таблиці
DROP TABLE IF EXISTS drivers;

-- Модифікація поля таблиці (зміна типу поля з DATETIME на DATE)
ALTER TABLE orders CHANGE COLUMN start start_date DATE NOT NULL;
ALTER TABLE orders CHANGE COLUMN finish finish_date DATE NOT NULL;

-- Заповнення таблиць

-- parks
INSERT INTO parks (address) VALUES ('51906 Chernihivska st');
INSERT INTO parks (address) VALUES ('51909 Stovby st');
INSERT INTO parks (address) VALUES ('51909 Shevchenka st');

-- cars
INSERT INTO cars (park_id, model, price) VALUES (1, 'Toyota Camry', 24000.00);
INSERT INTO cars (park_id, model, price) VALUES (2, 'Honda Accord', 22000.00);
INSERT INTO cars (park_id, model, price) VALUES (3, 'Ford Focus', 20000.00);

-- customers
INSERT INTO customers (name, phone) VALUES ('John Doe', '123-456-7890');
INSERT INTO customers (name, phone) VALUES ('Jane Smith', '234-567-8901');
INSERT INTO customers (name, phone) VALUES ('Bob Johnson', '345-678-9012');

-- orders
INSERT INTO orders (driver_id, customer_id, start_date, finish_date, total) VALUES (1, 1, '2024-05-01', '2024-05-01', 50.00);
INSERT INTO orders (driver_id, customer_id, start_date, finish_date, total) VALUES (2, 2, '2024-05-02', '2024-05-02', 60.00);
INSERT INTO orders (driver_id, customer_id, start_date, finish_date, total) VALUES (3, 3, '2024-05-03', '2024-05-03', 70.00);

-- Модифікація запису (зміна моделі автомобіля)
UPDATE cars SET model = 'Ford Fiesta' WHERE id = 1;

-- Видалення запису з таблиці
DELETE FROM customers WHERE id = 3;

-- SELECT запити

-- Вибірка всіх автопарків
SELECT * FROM parks;

-- Вибірка всіх автомобілів
SELECT * FROM cars;

-- JOIN запити

-- Вибірка замовлень з інформацією про водіїв та клієнтів
SELECT orders.id, drivers.name AS driver_name, customers.name AS customer_name, orders.start_date, orders.finish_date, orders.total
FROM orders
JOIN drivers ON orders.driver_id = drivers.id
JOIN customers ON orders.customer_id = customers.id;

-- Вибірка автомобілів з інформацією про автопарки
SELECT cars.id, cars.model, cars.price, parks.address
FROM cars
JOIN parks ON cars.park_id = parks.id;

-- Додавання нової колонки до таблиці cars
ALTER TABLE cars ADD COLUMN color VARCHAR(50) NOT NULL DEFAULT 'Unknown';

-- Зміна колонки в таблиці cars
ALTER TABLE cars CHANGE COLUMN color car_color VARCHAR(50) NOT NULL DEFAULT 'Unknown';

-- Вибірка автомобілів з ціною вище 21000
SELECT * FROM cars WHERE price > 21000;

-- Вибірка клієнтів з номером телефону, який починається з '123'
SELECT * FROM customers WHERE phone LIKE '123%';
