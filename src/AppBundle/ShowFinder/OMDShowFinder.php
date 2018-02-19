<?php


namespace AppBundle\ShowFinder;



use AppBundle\Entity\Categories;
use AppBundle\Entity\Show;
use GuzzleHttp\Client;
use Symfony\Component\Validator\Constraints\DateTime;

class OMDShowFinder implements ShowFinderInterface
{
    private $client;
    private $key;

    public function __construct(Client $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param String $query
     * @return Show|array|null
     */
    public function findByName($query)
    {
        $result = $this->client->get('/?apikey='.$this->key.'&type=series&t='.$query['name']);

        return $this->convertToShow(\GuzzleHttp\json_decode($result->getBody(),true));
    }

    /**
     * Create a private function transform a OMDB JSON into a show
     * @param $json
     *
     * Show $show
     */
    public function convertToShow($json)
    {
        if($json['Response'] == "False"){
            return null;
        }else{
            $categories = new Categories();
            $categories->setName($json['Genre']);

            $shows = [];
            $show = new Show();
            $show->setName($json['Title']);
            $show->getDatasource(Show::DATA_SOURCE_OMDB);
            $show->getAbstract('not provided.');
            $show->setCountry($json['Country']);
            $show->setAuthor('whoisit');
            $show->setDate(new \DateTime($json['Released']));
            $show->setImage($json['Poster']);
            $show->setCategories($categories);

            $shows = $show;

            return $shows;
        }

    }

    public function getName()
    {
        return 'Api_OMD';
    }
}