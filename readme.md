<h3>Blue Service Challenge</h3>

<h6>Escopo</h6>
  <p>O que deve ser desenvolvido?</p>
  <ul>
    <li>1 Lista de categorias;</li>
    <li>2 Lista de produtos;  </li>
    <li>3 Busca de produtos;  </li>
    <li>4 Detalhes do produto;</li>
    <li>5 Carrinho;           </li>
    <li>6 Criação do pedido;  </li>
    <li>7 Lista de pedidos;   </li>
  </ul>

<h6>Especificações funcionais:</h6>
    <ul>
      <li>Os produtos devem estar em um banco de dados relacional nos quais devem ser exibidos na lista;</li>
      <li>Os produtos devem possuir os seguintes atributos : nome, descrição, imagem, preço, categoria (um produto pode estar em mais de uma categoria) , características (devem ser pré-definidas e associadas ao produto); </li>
      <li>Não é obrigatório criar um layout elaborado;</li>
      <li>O carrinho deve ser mantido mesmo se o usuário navegar em outra pagina (nova busca / listagem / ou detalhe do produto ); </li>
      <li>O pedido deve ser salvo no banco de dados contemplando todos os itens do carrinho e os dados do usuário ( Pessoais e de entrega ); </li>
      <li>Não é necessário integração de nenhuma forma de pagamento, apenas gerar o registro do pedido no banco de dados; </li>
      <li>Todos os formulários devem ter as devidas validações no frontend e no backend; </li>
    </ul>
 
<h6>Especificações Técnicas:</h6>
  <p>Back-end</p>
  <ul>
    <li>1 Stack em PHP 8.1</li>
    <li>PostgreSQL 14</li>
    <li>Symfony</li>    
    <li>Docker</li>
    <li>Compose</li>
  </ul>
  </br>
  <p>Frond-end</p>
  <ul>
    <li>JavaScript</li>
    <li>jQuery 14</li>    
  </ul>

<h6> Como instalar ?</h6>

</br>
<p>
    Clonar o repositório
    https://github.com/DeversonBasilio/blueshop.git
</p>

<p>
    Abrir a pasta no terminal: /BLUESHOP
</p>

<p>
    rodar o comando: <b>docker-compose build</b>
</p>

<p>
    rodar o comando: <b>docker-compose up -d</b>
</p>

<p>
    rodar o comando: <b>docker exec -it php8-sf6 bash</b>
</p>

<p>
    Abra a pasta app: <b>cd app</b>
</p

<p>
    Pegue o Symfony runtime, rodando: <b>composer require symfony/runtime</b>
</p

<p>
    Crie a base de dados: php bin/console doctrine:database:create
</p

<p>
    Cria estrutura do banco: 
      <b>php bin/console make:migration  </b>
      <b>php bin/console doctrine:migrations:migrate   </b>
</p>

<p>
    yarn add --dev @symfony/webpack-encore -ignore--engines
    yarn encore dev --watch
</p>

<p>
    Rode o server: 
      <b> symfony serve -d </b>
</p>
  
<p>
    Acesse o projeto: 
      <b> http://127.0.0.1:8001/home </b>
</p>
