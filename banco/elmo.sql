create database dbelmo character set utf8mb4 collate utf8mb4_general_ci;
use dbelmo;

create table clinica( -- tabela com os dados do perifil da clinica
	Clin_id int auto_increment primary key, 
	Clin_Nome varchar(90), 
	Clin_Email varchar(90) unique not null,
	Clin_Username varchar(20) unique not null,
	Clin_Senha varchar(255),
	Clin_Biografia text, 
	Clin_Foto varchar(100), -- vai guardar o nome do do arquivo ao inves do arquivo em si
	Clin_CodVali int null, -- codigo de validação da conta
	Clin_DtCad datetime default current_timestamp, 
	Clin_DtDell datetime, -- data do soft delete 
	Clin_Status varchar(8), -- se o perfil está ativo ou desativado
	Clin_Cnpj varchar(14) unique, 
	Clin_Telefone varchar(11),
	Clin_notificacao text
);


create table profissional ( -- tabela do perfil do profissional
    pro_id int primary key auto_increment,
    pro_nome varchar(90),
    pro_email varchar(90) unique not null,
    pro_username varchar(20) unique not null,
    pro_senha varchar(255),
    pro_biografia text,
    pro_foto varchar(100),
    Pro_CodVali int,
    Pro_DtNasc date,
    Pro_DtCad datetime default current_timestamp,
    Pro_DtDell datetime null,
    Pro_Status varchar(8),
    Pro_CPF varchar(11) unique,
    Pro_CEP varchar(8),
    Pro_Telefone varchar(11),
    Pro_Genero varchar(6),
    Pro_Registro_Pro varchar(20), -- ainda não vi mas deve ter algum documento pra podologa poder atuar dps tem que ver tbm como verifica
    Pro_documentos varchar(90), -- aqui tbm vai ser só o nome que nem em foto
    Pro_notificacao text
);

create table cliente ( -- tabela do cliente
    Cli_id int auto_increment primary key,
    Cli_Nome varchar(90),
    Cli_Email varchar(90) unique,
    Cli_Username varchar(20) unique not null,
    Cli_Senha varchar(255),
    Cli_Biografia text,
    Cli_Foto varchar(100),
    Cli_CodVali int,
    Cli_DtNasc date,
    Cli_DtCad datetime default current_timestamp,
    Cli_DtDell datetime,
    Cli_Status varchar(8),
    Cli_CPF varchar(11) unique,
    Cli_Telefone varchar(11),
    Cli_Genero varchar(6),
    Cli_Documentos varchar(100),
    Cli_notificacao text
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
    Rel_id int auto_increment primary key,
    Pro_id int null,
    clin_id int null,
    dt_relatorio datetime,
    ttl_atendimentos int, -- total de atentimentos
    ttl_gnh decimal(10,2), -- ganho. Provavelmente vou ter que acrecentrar coisas 
    constraint fk_rel_pro foreign key (Pro_id) references profissional(pro_id) on delete set null on update cascade,
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

select * from profisional;

drop database dbelmo;


