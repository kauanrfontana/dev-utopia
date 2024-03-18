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
[state_id] int NOT NULL,
[name] varchar(50) NOT NULL
FOREIGN KEY ([state_id]) REFERENCES [states]([id])
);

CREATE TABLE [neighborhoods](
[id] int IDENTITY(1,1) PRIMARY KEY,
[city_id] int NOT NULL,
[name] varchar(50) NOT NULL,
FOREIGN KEY ([city_id]) REFERENCES [cities]([id])
);

CREATE TABLE [streets_avenues](
[id] int IDENTITY(1,1) PRIMARY KEY,
[neighborhood_id] int NOT NULL,
[name] varchar(50) NOT NULL,
FOREIGN KEY ([neighborhood_id]) REFERENCES [neighborhoods]([id])
);

CREATE TABLE [users](
[id] int IDENTITY(1, 1) PRIMARY KEY,
[name] varchar(100) NOT NULL,
[email] varchar(200) UNIQUE NOT NULL,
[password] varchar(200) NOT NULL,
[created_at] datetime NOT NULL,
[street_avenue_id] int,
[house_number] varchar(20),
[complement] varchar(200),
[zip_code] varchar(8),
FOREIGN KEY ([street_avenue_id]) REFERENCES [streets_avenues]([id])
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
[name] varchar(200) NOT NULL,
[description] varchar(400),
[created_at] datetime NOT NULL,
[price] money NOT NULL,
[street_avenue_id] int NOT NULL,
[house_number] varchar(5) NOT NULL,
[complement] varchar(200) NOT NULL,
[zip_code] varchar(8)
FOREIGN KEY ([street_avenue_id]) REFERENCES [streets_avenues]([id])
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


INSERT INTO roles ([name],[category], [created_at]) VALUES ('customer', 1, getDate());
INSERT INTO roles ([name],[category], [created_at]) VALUES ('seller', 2, getDate());
INSERT INTO roles ([name],[category], [created_at]) VALUES ('admin', 3, getDate());