create database dbelmo character set utf8mb4 collate utf8mb4_general_ci;
use dbelmo;

create table clinica( -- tabela com os dados do perifil da clinica
	clin_id int auto_increment primary key, 
	clin_nome varchar(90), 
	clin_email varchar(90) unique not null,
	clin_username varchar(20) unique not null,
	clin_senha varchar(255),
	clin_biografia text, 
	clin_foto varchar(100), -- vai guardar o nome do do arquivo ao inves do arquivo em si
	clin_vodVali int null, -- codigo de validação da conta
	clin_dtCad datetime default current_timestamp, 
	clin_dtDell datetime, -- data do soft delete 
	clin_status varchar(8), -- se o perfil está ativo ou desativado
	clin_cnpj varchar(14) unique,
	clin_cep varchar(8), 
	clin_telefone varchar(11),
	clin_notificacao text
);


create table profissional ( -- tabela do perfil do profissional
    pro_id int primary key auto_increment,
    pro_nome varchar(90),
    pro_email varchar(90) unique not null,
    pro_username varchar(20) unique not null,
    pro_senha varchar(255),
    pro_biografia text,
    pro_foto varchar(100),
    pro_codVali int,
    pro_dtNasc date,
    pro_dtCad datetime default current_timestamp,
    pro_dtDell datetime null,
    pro_status varchar(8),
    pro_CPF varchar(11) unique,
    pro_CEP varchar(8),
    pro_telefone varchar(11),
    pro_genero varchar(1),
    pro_registro varchar(20), -- ainda não vi mas deve ter algum documento pra podologa poder atuar dps tem que ver tbm como verifica
    pro_documentos varchar(90), -- aqui tbm vai ser só o nome que nem em foto
    pro_notificacao text
);

create table cliente ( -- tabela do cliente
    cli_id int auto_increment primary key,
    cli_nome varchar(90),
    cli_email varchar(90) unique,
    cli_username varchar(20) unique not null,
    cli_senha varchar(255),
    cli_biografia text,
    cli_foto varchar(100),
    cli_codVali int,
    cli_dtNasc date,
    cli_dtCad datetime default current_timestamp,
    cli_dtDell datetime,
    cli_status varchar(8),
    cli_CPF varchar(11) unique,
    cli_telefone varchar(11),
    cli_genero varchar(6),
    cli_documentos varchar(100),
    cli_notificacao text
);

create table servico (
    ser_id int auto_increment primary key,
    ser_pro int not null,
    ser_nome varchar(100) not null,
    ser_tipo varchar(50),
    ser_desc text,
    ser_tempo int, -- vai estar em minutos
    ser_val decimal(10,2), 
    ser_status varchar(8), -- se uma podologa deixar de fazer um serviço dar soft delete para manter o relatorio e atentimento sem dar problema
    constraint fk_ser_pro foreign key (ser_pro) references profissional(pro_id)on delete cascade on update cascade
);

create table permissoes (-- tabela que vai estar os tipos de permissoes que tem
	perm_id int auto_increment primary key,
    perm_desc text
);

create table profissional_clinica ( -- como faremos de forma que o podologo pode ter + de 1 associação tipo ela oferece um serviço no proprio nome já que a clinica não oferece esse serviço por isso uma tabela relacionanto os 2 e não um campo com null pra poder não ter associação
    pc_id int auto_increment primary key,
    pc_pro int not null,
    pc_clin int not null,
    constraint fk_pc_pro foreign key (pc_pro) references profissional(pro_id) on delete cascade on update cascade,
    constraint fk_pc_clin foreign key (pc_clin) references clinica(clin_id) on delete cascade on update cascade
);

create table menu_permissao ( -- tabela que vai associar as permissoes e clinicas e seus associados
	mnperm_id int auto_increment primary key,
    mnperm_perm int null,
    mnperm_pc int null,
    constraint fk_mnperm_perm foreign key (mnperm_perm) references permissoes(perm_id) on delete cascade on update cascade,
	constraint fk_mnperm_pc foreign key (mnperm_pc) references profissional_clinica(pc_id) on delete set null on update cascade
);

create table relatorio (-- como queremos guardar os relatorios e que as clinicas possam acessar ela então criamos uma tabela pra isso
    rel_id int auto_increment primary key,
    pro_id int null,
    clin_id int null,
    dt_relatorio datetime,
    ttl_atendimentos int, -- total de atentimentos
    ttl_gnh decimal(10,2), -- ganho. Provavelmente vou ter que acrecentrar coisas 
    constraint fk_rel_pro foreign key (pro_id) references profissional(pro_id) on delete set null on update cascade,
    constraint fk_rel_clin foreign key (clin_id) references clinica(clin_id) on delete set null on update cascade
);

create table hr_servico ( -- para cada dia em que a podologa trabralhar vai ter um horario de inicio e terminio e vai servir tbm pra verificar se o horario corresponde ao horario livre
    hrser_id int auto_increment primary key,
    hrser_pro int not null,
    hrser_hora_inic time,
    hrser_hora_term time,
    hrser_dia enum('DOM','SEG','TER','QUA','QUI','SEX','SAB'),
    foreign key (hrser_pro) references profissional(pro_id) on delete cascade
);

create table agenda (-- aqui vai estar os horarios das consultas
    agnd_id int primary key auto_increment,
    agnd_pro int not null,
    agnd_cli int,
    agnd_ser int not null,
    agnd_data datetime,
    constraint fk_agnd_pro foreign key (agnd_pro) references profissional(pro_id) on delete cascade ,
	constraint fk_agnd_cli foreign key (agnd_cli) references cliente(cli_id) on delete set null,
    constraint fk_agnd_ser foreign key (agnd_ser) references servico(ser_id) 
);

create table atendimento ( -- esse vai salvar pra fazer o relatorio e mander no historico
	atd_id int primary key auto_increment, 
	atd_pro int, 
	atd_agnd int, 
	atd_cli int, 
	atd_data datetime, 
    atd_ser int not null,
	constraint fk_atd_pro foreign key (atd_pro) references profissional(pro_id) on delete set null, 
	constraint fk_atd_agn foreign key (atd_agnd) references agenda(agnd_id) on delete set null, 
	constraint fk_atd_cli foreign key (atd_cli) references cliente(cli_id) on delete set null,
    constraint fk_atd_ser foreign key (atd_ser) references servico(ser_id)  on delete cascade
);

select * from profissional;

drop database dbelmo;


