CREATE DATABASE devutopia;

USE devutopia;

CREATE TABLE [countries](
[id] int IDENTITY(1,1) PRIMARY KEY,
[name] varchar(50) NOT NULL
);

CREATE TABLE [states](
[id] int IDENTITY(1,1) PRIMARY KEY,
[country_id] int NOT NULL,
[name] varchar(50) NOT NULL
FOREIGN KEY ([country_id]) REFERENCES [countries]([id])
);

CREATE TABLE [cities](
[id] int IDENTITY(1,1) PRIMARY KEY,
[country_id] int NOT NULL,
[state_id] int NOT NULL,
[name] varchar(50) NOT NULL
FOREIGN KEY ([country_id]) REFERENCES [countries]([id]),
FOREIGN KEY ([state_id]) REFERENCES [states]([id])
);

CREATE TABLE [address](
[id] int IDENTITY(1,1) PRIMARY KEY,
[country_id] int NOT NULL,
[state_id] int NOT NULL,
[city_id] int NOT NULL,
[street_avenue] varchar(200) NOT NULL,
[house_number] varchar(20) NOT NULL,
[complement] varchar(200),
[zip_code] varchar(20) NOT NULL,
[created_at] datetime NOT NULL,
FOREIGN KEY ([country_id]) REFERENCES [countries]([id]),
FOREIGN KEY ([state_id]) REFERENCES [states]([id]),
FOREIGN KEY ([city_id]) REFERENCES [cities]([id])
);

CREATE TABLE [location](
[id] int IDENTITY(1,1) PRIMARY KEY,
[country_id] int NOT NULL,
[state_id] int NOT NULL,
[city_id] int NOT NULL,
[address_id] int NOT NULL,
FOREIGN KEY ([country_id]) REFERENCES [countries]([id]),
FOREIGN KEY ([state_id]) REFERENCES [states]([id]),
FOREIGN KEY ([city_id]) REFERENCES [cities]([id]),
FOREIGN KEY ([address_id]) REFERENCES [address]([id])
);

CREATE TABLE [roles](
[id] int IDENTITY(1,1) PRIMARY KEY,
[name] varchar(50) NOT NULL,
[created_at] datetime NOT NULL
);

CREATE TABLE [users](
[id] int IDENTITY(1, 1) PRIMARY KEY,
[name] varchar(100) NOT NULL,
[email] varchar(200) UNIQUE NOT NULL,
[password] varchar(200) NOT NULL,
[created_at] datetime NOT NULL,
[location_id] int NOT NULL,
FOREIGN KEY ([location_id]) REFERENCES [location]([id])
);

CREATE TABLE [user_roles](
[user_id] int NOT NULL,
[role_id] int NOT NULL,
PRIMARY KEY([user_id], [role_id]),
FOREIGN KEY([user_id]) REFERENCES [users]([id]),
FOREIGN KEY([role_id]) REFERENCES [roles]([id])
); 

CREATE TABLE [products](
[id] int IDENTITY(1,1) PRIMARY KEY,
[name] varchar(200) NOT NULL,
[description] varchar(400),
[created_at] datetime NOT NULL,
[price] money NOT NULL,
[location_id] int NOT NULL
FOREIGN KEY ([location_id]) REFERENCES [location]([id])
);

CREATE TABLE [shopping_carts](
[id] int IDENTITY(1,1) PRIMARY KEY,
[user_id] int NOT NULL,
[qtd_itens] int NOT NULL,
[total_price] money NOT NULL,
FOREIGN KEY ([user_id]) REFERENCES [users]([id])
);

CREATE TABLE [shopping_cart_products](
[id] int IDENTITY(1,1) PRIMARY KEY,
[shopping_cart_id] int NOT NULL,
[product_id] int NOT NULL,
[qtd] int NOT NULL,
FOREIGN KEY ([shopping_cart_id]) REFERENCES [shopping_carts]([id]),
FOREIGN KEY ([product_id]) REFERENCES [products]([id])
);