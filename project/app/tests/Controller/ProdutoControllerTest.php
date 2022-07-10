<?php

namespace App\Test\Controller;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProdutoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProdutoRepository $repository;
    private string $path = '/produto/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Produto::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produto index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'produto[nome]' => 'Testing',
            'produto[descricao]' => 'Testing',
            'produto[imagem]' => 'Testing',
            'produto[preco]' => 'Testing',
            'produto[categorias]' => 'Testing',
        ]);

        self::assertResponseRedirects('/produto/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produto();
        $fixture->setNome('My Title');
        $fixture->setDescricao('My Title');
        $fixture->setImagem('My Title');
        $fixture->setPreco('My Title');
        $fixture->setCategorias('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produto');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produto();
        $fixture->setNome('My Title');
        $fixture->setDescricao('My Title');
        $fixture->setImagem('My Title');
        $fixture->setPreco('My Title');
        $fixture->setCategorias('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produto[nome]' => 'Something New',
            'produto[descricao]' => 'Something New',
            'produto[imagem]' => 'Something New',
            'produto[preco]' => 'Something New',
            'produto[categorias]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produto/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNome());
        self::assertSame('Something New', $fixture[0]->getDescricao());
        self::assertSame('Something New', $fixture[0]->getImagem());
        self::assertSame('Something New', $fixture[0]->getPreco());
        self::assertSame('Something New', $fixture[0]->getCategorias());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Produto();
        $fixture->setNome('My Title');
        $fixture->setDescricao('My Title');
        $fixture->setImagem('My Title');
        $fixture->setPreco('My Title');
        $fixture->setCategorias('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/produto/');
    }
}
