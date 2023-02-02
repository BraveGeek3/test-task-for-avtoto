<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201083320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE warehouses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE addresses (id VARCHAR(255) NOT NULL, region VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, building_number VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT \'
                            Доставка
                        \' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE clients (id VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74E7927C74 ON clients (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E746B01BC5B ON clients (phone_number)');
        $this->addSql('CREATE TABLE orders (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) NOT NULL, address_id VARCHAR(255) DEFAULT NULL, transport_company_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, delivery_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE19EB6921 ON orders (client_id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEF5B7AF75 ON orders (address_id)');
        $this->addSql('CREATE TABLE orders_products (id VARCHAR(255) NOT NULL, product_id VARCHAR(255) NOT NULL, order_id VARCHAR(255) NOT NULL, ordered_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_749C879C4584665A ON orders_products (product_id)');
        $this->addSql('CREATE INDEX IDX_749C879C8D9F6D38 ON orders_products (order_id)');
        $this->addSql('CREATE TABLE products (id VARCHAR(255) NOT NULL, warehouse_id VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, available_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A2B36786B ON products (title)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A5080ECDE ON products (warehouse_id)');
        $this->addSql('CREATE TABLE warehouses (id VARCHAR(255) NOT NULL, address_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFE9C2B7F5B7AF75 ON warehouses (address_id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders_products ADD CONSTRAINT FK_749C879C4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders_products ADD CONSTRAINT FK_749C879C8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A5080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE warehouses ADD CONSTRAINT FK_AFE9C2B7F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE warehouses_id_seq CASCADE');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEE19EB6921');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEEF5B7AF75');
        $this->addSql('ALTER TABLE orders_products DROP CONSTRAINT FK_749C879C4584665A');
        $this->addSql('ALTER TABLE orders_products DROP CONSTRAINT FK_749C879C8D9F6D38');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A5080ECDE');
        $this->addSql('ALTER TABLE warehouses DROP CONSTRAINT FK_AFE9C2B7F5B7AF75');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_products');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE warehouses');
    }
}
