# Ponderada Semana 3 - Elaboração de aplicação web integrada a um banco de dados

## Introdução

&emsp;&emsp;Este tutorial demonstra como instalar um servidor web Apache com PHP e criar um banco de dados MySQL. O servidor web será executado em uma instância Amazon EC2 utilizando o Amazon Linux 2023, enquanto a instância do banco de dados foi configurada com MySQL. Ambos os componentes, a instância Amazon EC2 e a instância do banco de dados, serão implantados em uma nuvem virtual privada (VPC) baseada no serviço Amazon VPC, proporcionando um ambiente seguro e escalável para suas aplicações web.

**Video da Demonstração**: https://youtu.be/og-xG17TeeQ

## Tecnologias Utilizadas:

&emsp;&emsp;Para a resolução desta questão ponderada, eu utilizei as seguintes tecnologias:

- **PHP**:
    - O PHP foi utilizado para construir o backend do servidor web, permitindo a criação de páginas dinâmicas que se comunicam com o banco de dados. PHP é uma linguagem amplamente adotada para desenvolvimento web devido à sua simplicidade e flexibilidade, além de ser perfeitamente compatível com o Apache, que é o servidor web utilizado neste projeto.

- **Amazon EC2**:
    - Amazon EC2 foi escolhido para hospedar o servidor web Apache, fornecendo uma instância escalável e configurável. A escolha da EC2 se deve à sua capacidade de executar aplicações em uma infraestrutura virtual segura e flexível, com controle completo sobre o ambiente de execução, o que é essencial para o gerenciamento de servidores e o deployment de aplicações em produção.

- **Amazon RDS**:
    - O Amazon RDS foi utilizado para gerenciar a instância do banco de dados, oferecendo um serviço de banco de dados escalável, com backup automático, alta disponibilidade e segurança. Optar pelo RDS facilita o gerenciamento das operações do banco de dados, como configuração, backups, patching e replicação, permitindo que o foco seja mantido no desenvolvimento da aplicação.

## Modelagem do Banco de Dados

&emsp;&emsp;A modelagem do banco de dados foi orientada pelo objetivo de recriar o time que jogou o Mundial de Clubes de 2012 pelo Corinthians. A tabela, nomeada como **_Corinthians_2012_**, foi projetada para armazenar informações essenciais sobre os jogadores, incluindo seus identificadores, nomes, posições em campo, número de gols marcados e datas de nascimento.

&emsp;&emsp;A estrutura da tabela foi definida com as seguintes colunas:

- **Jogador_ID**: Um identificador exclusivo para cada jogador (do tipo `INT`), que também serve como chave primária da tabela.
- **Nome**: O nome completo do jogador (do tipo `VARCHAR(50)`), garantindo que o campo não possa ficar em branco.
- **Posição**: A posição em que o jogador atua (do tipo `VARCHAR(20)`), também definida como um campo obrigatório.
- **Gols**: O número de gols que o jogador marcou no ano de 2012 (do tipo `INT`).
- **Data de Nascimento**: A data de nascimento do jogador (do tipo `DATE`), permitindo armazenar esta informação em um formato adequado para futuras consultas e análises.

### Estrutura Inicial dos Dados

A tabela foi populada com os dados de alguns dos principais jogadores que participaram da conquista do título, conforme ilustrado a seguir:

| Jogador_ID | Nome      | Posição | Gols | Data de Nascimento |
|------------|-----------|---------|------|---------------------|
| 1          | Cássio    | Goleiro | 10   | 1987-06-06          |
| 2          | Guerrero  | Atacante| 2    | 1984-01-01          |
| 3          | Chicão    | Zagueiro| 0    | 1981-06-03          |

&emsp;&emsp;Para criar essa tabela no banco de dados MySQL, o seguinte comando SQL foi utilizado:

```sql
CREATE TABLE Corinthians_2012 (
    Jogador_ID INT PRIMARY KEY,         -- Identificação única do jogador
    Nome VARCHAR(50) NOT NULL,          -- Nome do jogador
    Posição VARCHAR(20) NOT NULL,       -- Posição em que jogava
    Gols INT,                           -- Número de gols marcados em 2012
    Data_Nascimento DATE                -- Data de nascimento do jogador
);
```

&emsp;&emsp;Após a criação da tabela, foi necessário modificar a coluna `Jogador_ID` para que ela se tornasse autoincrementável, assegurando que novos registros fossem inseridos automaticamente com identificadores únicos, sem a necessidade de atribuir um valor manualmente:

```sql
ALTER TABLE Corinthians_2012 MODIFY Jogador_ID INT NOT NULL AUTO_INCREMENT;
```

&emsp;&emsp;Com essa estrutura, a tabela **_Corinthians_2012_** está preparada para armazenar e organizar os dados dos jogadores de forma eficiente, facilitando o acesso e a manipulação das informações necessárias para a aplicação.

## Descrição de como foi realizado

A criação do servidor web e da instância de banco de dados foi feita em várias etapas. Inicialmente, foi lançada uma instância EC2 utilizando o Amazon Linux 2023, onde o Apache e o PHP foram instalados e configurados para servir páginas web dinâmicas. Em paralelo, foi criada uma instância de banco de dados Amazon RDS utilizando MySQL, escolhendo uma configuração que atenda às necessidades da aplicação em termos de performance e segurança.

Depois de configurar a comunicação segura entre a instância EC2 e o banco de dados RDS através de uma VPC (Virtual Private Cloud), foi possível integrar o servidor web com o banco de dados. A VPC garante que todo o tráfego de rede permaneça privado, aumentando a segurança da solução. O ambiente resultante permite que as páginas PHP possam consultar, atualizar e manipular os dados armazenados no RDS, criando uma aplicação web totalmente funcional e escalável.