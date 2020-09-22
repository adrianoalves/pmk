### Processo Seletivo - Programador PHP

#### Sobre o Teste

Segui os requisitos da descrição do teste o mais próximo possível do solicitado. Apliquei o conceito de CRUD nas Entidades identificadas e apliquei o máximo possível de conceitos SOLID.
Variei um pouco no Routing para aplicar tanto a forma simples quanto a forma utilizada para desenvolver APIs Rest.

Porém, em alguns pontos e considerando um cenário de projeto real, eu faria diferente por questões de arquitetura e manutenibilidade.
Um destes pontos é sobre a forma de Pagamento com tabelas diferentes para cada tipo.
Atualmente existem várias formas de pagamento que estão em constante evolução, e à medida que o sistema implementa novas formas, ter uma tabela para cada
uma pode dificultar a evolução do sistema. Hoje em dia, é possível pagar/doar/compensar/trocar com criptomoedas e até com pontos ou milhas de programas de fidelidade.

No javascript, apesar de usar muito a Fetch API nativa do ES6, neste usei Axios pela ampla adoção e bundle padrão no Laravel.

#### Stack Utilizada

Para realizar o Teste, usei:
- [Laravel 8](https://laravel.com);
- [Vuejs](https://vuejs.org/);
- [Vue Router](https://router.vuejs.org/);
- [Vuelidate](https://vuelidate.js.org/);
- [Vue Input Mask](https://www.npmjs.com/package/v-mask);
- [Bootstrap](https://getbootstrap.com).

#### Como instalar

- Leia as instruções de instalação de ambiente [Laravel 8](https://laravel.com/docs/8.x/installation);
- Certifique-se de possuir o ambiente de desenvovolvimento com [npm instalado](https://www.npmjs.com/get-npm);
- Clone o projeto `git clone https://github.com/adrianoalves/pmk.git .` ;
- Crie um banco de dados denominado `donate`;
- Configure o arquivo .env;
- acesse a raiz do projeto e execute os seguintes comandos;
- Execute `composer update`, 
- Para rodar o front, execute `npm run dev` ou `npm run watch`.

#### Considerações Finais

O Dump do banco está em database/schema/mysql-schema.sql.

Obrigado pela oportunidade de Participar!
