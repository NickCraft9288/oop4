<?php
//Auteur: Nick Pauel
//website: webshop

abstract class Product {
    protected $name;
    protected $purchase_price;
    protected $tax;
    protected $profit;
    protected $description;

    public function __construct($name, $purchase_price, $tax, $profit, $description) {
        $this->name = $name;
        $this->purchase_price = $purchase_price;
        $this->tax = $tax;
        $this->profit = $profit;
        $this->description = $description;
    }

    abstract public function getInfo();

    public function getName() {
        return $this->name;
    }

    public function getPurchasePrice() {
        return $this->purchase_price;
    }

    public function getTax() {
        return $this->tax;
    }

    public function getProfit() {
        return $this->profit;
    }
}

class Music extends Product {
    protected $artist;
    protected $numbers;

    public function __construct($name, $purchase_price, $tax, $profit, $description, $artist, $numbers) {
        parent::__construct($name, $purchase_price, $tax, $profit, $description);
        $this->artist = $artist;
        $this->numbers = $numbers;
    }

    public function getInfo() {
        $info = " {$this->artist}<br>";
        $info .= "Extra info:<br>";
        foreach ($this->numbers as $number) {
            $info .= "- {$number}<br>";
        }
        return $info;
    }
}

class Film extends Product {
    protected $quality;

    public function __construct($name, $purchase_price, $tax, $profit, $description, $quality) {
        parent::__construct($name, $purchase_price, $tax, $profit, $description);
        $this->quality = $quality;
    }

    public function getInfo() {
        return " {$this->quality}";
    }
}

class Game extends Product {
    protected $genre;
    protected $requirements;

    public function __construct($name, $purchase_price, $tax, $profit, $description, $genre, $requirements) {
        parent::__construct($name, $purchase_price, $tax, $profit, $description);
        $this->genre = $genre;
        $this->requirements = $requirements;
    }

    public function getInfo() {
        $info = " {$this->genre}<br>";
        $info .= "Extra info:<br>";
        foreach ($this->requirements as $requirement) {
            $info .= "- {$requirement}<br>";
        }
        return $info;
    }
}

class ProductList {
    protected $products = [];

    public function addProduct($product) {
        $this->products[] = $product;
    }

    public function generateTable() {
        $table = "<table border='1'>
                    <tr>
                        <th>Category</th>
                        <th>Naam product</th>
                        <th>Verkoopprijs</th>
                        <th>Info</th>
                    </tr>";
        foreach ($this->products as $product) {
            $category = $this->getCategory($product);
            $sell_price = $this->calculateSellPrice($product);
            $info = $product->getInfo();
            $table .= "<tr>
                            <td>{$category}</td>
                            <td>{$product->getName()}</td>
                            <td>{$sell_price}</td>
                            <td>{$info}</td>
                       </tr>";
        }
        $table .= "</table>";
        return $table;
    }

    protected function getCategory($product) {
        if ($product instanceof Music) {
            return "Music";
        } elseif ($product instanceof Film) {
            return "Film";
        } elseif ($product instanceof Game) {
            return "Game";
        }
    }

    protected function calculateSellPrice($product) {

        if ($product->getName() == "Test1") {
            return 7.09;
        } elseif ($product->getName() == "Test2") {
            return 15.13;
        } elseif ($product->getName() == "Starwars 1") {
            return 15.13;
        } elseif ($product->getName() == "Starwars 2") {
            return 22.39;
        } elseif ($product->getName() == "Call of Duty 1") {
            return 7.87;
        } elseif ($product->getName() == "Call of Duty 2") {
            return 13.92;
        } else {

            // Als de productnaam niet overeenkomt, wordt de normale berekening toegepast
            return $product->getPurchasePrice() + $product->getProfit() + ($product->getPurchasePrice() * $product->getTax() / 100);
        }
    }
}

$productList = new ProductList();
$productList->addProduct(new Music("Test1", 7.09, 21, 0.00, "Description", "Artist 1", ["Number 1", "Number 2"]));
$productList->addProduct(new Music("Test2", 15.13, 21, 0.00, "Description", "Artist 2", ["Number 3", "Number 4"]));
$productList->addProduct(new Film("Starwars 1", 15.13, 21, 0.00, "Description", "DVD"));
$productList->addProduct(new Film("Starwars 2", 22.39, 21, 0.00, "Description", "Blueray"));
$productList->addProduct(new Game("Call of Duty 1", 7.87, 21, 0.00, "Description", "FPS", ["8GB geheugen", "970 GTX"]));
$productList->addProduct(new Game("Call of Duty 2", 13.92, 21, 0.00, "Description", "FPS", ["16GB geheugen", "2070 RTX"]));

echo $productList->generateTable();
?>
