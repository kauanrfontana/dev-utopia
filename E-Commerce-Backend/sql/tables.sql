CREATE DATABASE devutopia;

USE devutopia;

CREATE TABLE [users](
[id] int IDENTITY(1, 1) PRIMARY KEY,
[name] varchar(100) NOT NULL,
[email] varchar(200) UNIQUE NOT NULL,
[password] varchar(200) NOT NULL,
[created_at] datetime NOT NULL,
[state_id] int,
[city_id] int,
[address] varchar(200),
[house_number] varchar(20),
[complement] varchar(200),
[zip_code] varchar(8)
);

CREATE TABLE [roles](
[id] int IDENTITY(1,1) PRIMARY KEY,
[category] int NOT NULL,
[name] varchar(50) NOT NULL,
[created_at] datetime NOT NULL
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
[user_id] int NOT NULL,
[name] varchar(200) NOT NULL,
[url_image] varchar(500),
[description] varchar(400),
[created_at] datetime NOT NULL,
[price] money NOT NULL,
[state_id] int NOT NULL,
[city_id] int NOT NULL,
[address] varchar(200) NOT NULL,
[house_number] varchar(5) NOT NULL,
[complement] varchar(200),
[zip_code] varchar(8) NOT NULL,
FOREIGN KEY ([user_id]) REFERENCES [users]([id])
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

CREATE TABLE [tokens] (
[id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
[user_id] INT NOT NULL,
[token] VARCHAR(1000) NOT NULL,
[refresh_token] VARCHAR(1000) NOT NULL,
[expired_at] datetime NOT NULL,
[active] TINYINT NOT NULL DEFAULT 1,
FOREIGN KEY ([user_id]) REFERENCES [users]([id])
);
