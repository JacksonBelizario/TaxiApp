-- Drop table

-- DROP TABLE public.motorista

CREATE TABLE motorista (
	id_motorista serial NOT NULL,
	email varchar(150) NOT NULL,
	nome varchar(300) NOT NULL,
	contato varchar(20) NULL,
	senha varchar(150) NOT NULL,
	endereco varchar(100) NULL,
	documento int4 NOT NULL,
	CONSTRAINT motorista_pk PRIMARY KEY (id_motorista),
	CONSTRAINT motorista_un UNIQUE (email)
)
WITH (
	OIDS=FALSE
) ;
CREATE INDEX motorista_email_idx ON motorista USING btree (email) ;

-- Drop table

-- DROP TABLE cliente

CREATE TABLE cliente (
	id_cliente serial NOT NULL,
	email varchar(150) NOT NULL,
	nome varchar(300) NOT NULL,
	contato varchar(20) NULL,
	senha varchar(150) NOT NULL,
	CONSTRAINT cliente_pk PRIMARY KEY (id_cliente),
	CONSTRAINT cliente_un UNIQUE (email)
);

CREATE INDEX cliente_email_idx ON cliente USING btree (email);


CREATE TABLE veiculo (
	id_motorista int4 NOT NULL,
	placa varchar(10) NOT NULL,
	modelo varchar(10) NULL,
	tipo varchar(10) NULL,
	CONSTRAINT veiculo_un UNIQUE (placa)
);

CREATE TABLE viagem (
	id_cliente int4 NOT NULL,
	id_motorista int4 NULL,
	id_viagem int4 NOT NULL,
	status varchar(10) NOT NULL,
	duracao time NULL,
	distancia numeric(5,2) NOT NULL,
	forma_pagamento varchar(5) NULL,
	valor numeric(10,2) NULL,
	origem varchar(150) NOT NULL,
	destino varchar(150) NOT NULL,
	data_hora timestamp NULL,
	CONSTRAINT viagem_pk PRIMARY KEY (id_viagem)
);

ALTER TABLE veiculo ADD	CONSTRAINT veiculo_motorista_fk FOREIGN KEY (id_motorista) REFERENCES motorista(id_motorista);
ALTER TABLE viagem ADD CONSTRAINT viagem_cliente_fk FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente);
ALTER TABLE viagem ADD CONSTRAINT viagem_motorista_fk FOREIGN KEY (id_motorista) REFERENCES motorista(id_motorista);

INSERT INTO motorista (email, nome, contato, senha, endereco, documento, id_motorista) VALUES('mot@gmail.com', 'José Silva', '(67) 99999-9999', '123', 'Rua Bahia, 490 - Vila 1', 8451982, 1);
INSERT INTO motorista (email, nome, contato, senha, endereco, documento, id_motorista) VALUES('mot2@email.com', 'João Pedro', '(67) 98289-9888', '6585', 'Rua XYZ, 3545', 83286, 2);
INSERT INTO motorista (email, nome, contato, senha, endereco, documento, id_motorista) VALUES('mot3@teste.com', 'Marcos Silva', '(67) 98272-2331', '98325', 'Rua W1', 876218, 3);

INSERT INTO veiculo (placa, modelo, tipo, id_motorista) VALUES('XYZ-1243', 'Fiesta', 'hatch', 1);
INSERT INTO veiculo (placa, modelo, tipo, id_motorista) VALUES('IFN-4365', 'Corolla', 'sedan', 2);
INSERT INTO veiculo (placa, modelo, tipo, id_motorista) VALUES('OFM-3513', 'Gol', 'hatch', 3);
INSERT INTO veiculo (placa, modelo, tipo, id_motorista) VALUES('OWM-6231', 'Fusion', 'sedan', 1);


INSERT INTO cliente (email, nome, contato, senha, id_cliente) VALUES('cli@email.com', 'Ana Pereira', '(67) 92431-2412', '564982', 1);
INSERT INTO cliente (email, nome, contato, senha, id_cliente) VALUES('cli2@dfsd.com', 'Mario Santos', '(67) 98723-1231', '64232', 2);
INSERT INTO cliente (email, nome, contato, senha, id_cliente) VALUES('cli3@sadc.com', 'Murilo de Paula', '(67) 97928-2312', '24000', 3);
INSERT INTO cliente (email, nome, contato, senha, id_cliente) VALUES('cli4@sxxc.com', 'Joana Josué', '(67) 98723-1231', '3565230', 4);
INSERT INTO cliente (email, nome, contato, senha, id_cliente) VALUES('cli4@teste.com', 'Eliana Silva', '(67) 98772-2313', '32155', 5);


INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('1', NULL, 67.00, NULL, NULL, 'Rua X', 'Rua Y', 1, NULL, 1, '2018-07-01 08:07:50.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('2', NULL, 87.00, NULL, NULL, 'Rua K', 'Rua W', 2, 1, 2, '2018-07-01 09:10:24.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('3', '00:00:32', 45.00, 'car', 35.00, 'Rua A', 'Rua B', 3, 2, 3, '2018-07-01 13:17:04.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('3', '00:00:56', 85.00, 'din', 48.00, 'Rua 1', 'Rua 10', 1, 3, 4, '2018-07-02 06:16:21.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('1', NULL, 12.00, NULL, NULL, 'Rua 2', 'Rua 21', 2, NULL, 5, '2018-07-02 11:16:34.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('3', '00:01:34', 125.00, 'din', 150.00, 'Rua A', 'Rua Y', 1, 1, 6, '2018-07-03 12:24:33.000');
INSERT INTO viagem (status, duracao, distancia, forma_pagamento, valor, origem, destino, id_cliente, id_motorista, id_viagem, data_hora) VALUES('2', NULL, 86.00, '', NULL, 'Rua B', 'Rua O', 3, 3, 7, '2018-07-04 13:16:54.000');
