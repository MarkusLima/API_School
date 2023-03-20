# Projeto API School

## (Mini mundo)Descrição do projeto
```
O Diretor de uma escola deseja que sua escola tenha sistema onde ele possa cadastrar 
seu professores, alunos e turmas.
O cadastro do professor terá que ter nome, endereço e registro de o criou.
O cadastro do aluno terá que ter nome, endereço, idade e registro de o criou.
A cadastro de turmas terá o nome da turma, id do professor e id do aluno.
```

## PITURES

![App Screenshot](/docs/Capturar1.PNG?text=App+Screenshot+Here)
![App Screenshot](/docs/Capturar2.PNG?text=App+Screenshot+Here)

## Tecnologias ultilizadas
```
Laravel 8
RestFull
Php
Swagger
PhpUnit
```

## Endpoints ultilizados
```
http://localhost/api/documentation
```

## Instruções para rodar o projeto
```
Via Laragon:
- Instalar laragon  
- Clonar o projeto para dentro da pasta www/
- Fazer uma copia do arquivo .ENV.EXAMPLE e renomear para .ENV
- Colocar as credencias da base de dados no arquivo .ENV
- Abrir http://localhost 
- Abrir http://localhost/phpmyadmin/
- Rodar php artisan migrate para gerar os migrations
- Rodar php artisan key:generate
- Pode importar o arquivo School.postman_collection.json para o postman
```

```
Via Xampp:
- Instalar Xampp  
- Clonar o projeto para dentro da pasta htdocs/
- Fazer uma copia do arquivo .ENV.EXAMPLE e renomear para .ENV
- Colocar as credencias da base de dados no arquivo .ENV
- Abrir http://localhost 
- Abrir http://localhost/phpmyadmin/
- Rodar php artisan migrate para gerar os migrations
- Rodar php artisan key:generate
- Pode importar o arquivo School.postman_collection.json para o postman
```

## Testes
```
./vendor/bin/phpunit

```