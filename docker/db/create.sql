DROP DATABASE if EXISTS trade_platform;

CREATE DATABASE trade_platform;

CREATE TABLE trade_platform.account (
    account_id CHAR(36),
    name VARCHAR(120),
    email VARCHAR(120),
    document VARCHAR(11),
    password VARCHAR(64),
    PRIMARY KEY (account_id)
);

CREATE TABLE trade_platform.account_asset (
    account_id CHAR(36),
    asset_id CHAR(10),
    quantity DECIMAL,
    PRIMARY KEY (account_id, asset_id)
);

CREATE TABLE trade_platform.order (
    order_id CHAR(36),
    market_id VARCHAR(16),
    account_id CHAR(36),
    side CHAR(4),
    quantity DECIMAL,
    price DECIMAL,
    fill_quantity DECIMAL,
    fill_price DECIMAL,
    status CHAR(12),
    timestamp TIMESTAMP,
    PRIMARY KEY (order_id)
);
