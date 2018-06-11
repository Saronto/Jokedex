<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JokeRepository")
 * @ORM\Table(name="joke")
 */
class Joke
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $joke;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getJoke()
    {
        return $this->joke;
    }

    /**
     * @param mixed $joke
     */
    public function setJoke($joke)
    {
        $this->joke = $joke;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
}