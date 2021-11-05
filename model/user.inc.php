<?php

class User
{
    private $login;
    private $password;
    private $name;
    private $fname;
    private $gender;
    private $email;
    private $birthdate;
    private $address;
    private $postcode;
    private $city;
    private $phone;
    private $favorite_recipes;

    private function __construct(
        $login,
        $password,
        $name,
        $fname,
        $gender,
        $email,
        $birthdate,
        $address,
        $postcode,
        $city,
        $phone,
        $favorite_recipes = []
    ) {
        $this->login = strtolower(trim(htmlspecialchars($login)));
        $this->password = $password;
        $this->setName($name);
        $this->setFirstName($fname);
        $this->setGender($gender);
        $this->setEmail($email);
        $this->setBirthdate($birthdate);
        $this->setAddress($address);
        $this->setPostcode($postcode);
        $this->setCity($city);
        $this->setPhone($phone);
        $this->setFavoriteRecipes($favorite_recipes);
    }

    public static function fromArray($array)
    {
        return new static(
            $array['login'],
            $array['password'],
            isset($array['name']) ? $array['name'] : '',
            isset($array['fname']) ? $array['fname'] : '',
            isset($array['gender']) ? $array['gender'] : '',
            isset($array['email']) ? $array['email'] : '',
            isset($array['birthdate']) ? $array['birthdate'] : '',
            isset($array['address']) ? $array['address'] : '',
            isset($array['postcode']) ? $array['postcode'] : '',
            isset($array['city']) ? $array['city'] : '',
            isset($array['phone']) ? $array['phone'] : '',
            isset($array['favorite_recipes']) ? $array['favorite_recipes'] : []
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'login' => $this->login,
            'password' => $this->password,
            'name' => $this->name,
            'fname' => $this->fname,
            'gender' => $this->gender,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'phone' => $this->phone,
            'favorite_recipes' => $this->favorite_recipes
        ];
    }

    public function editProfile(User $user)
    {
        if ($this->name !== $user->getName())
            $this->setName($user->getName());

        if ($this->fname !== $user->getFirstName())
            $this->setFirstName($user->getFirstName());

        if ($this->gender !== $user->getGender())
            $this->setGender($user->getGender());

        if ($this->email !== $user->getEmail())
            $this->setEmail($user->getEmail());

        if ($this->birthdate !== $user->getBirthdate())
            $this->setBirthdate($user->getBirthdate());

        if ($this->address !== $user->getAddress())
            $this->setAddress($user->getAddress());

        if ($this->postcode !== $user->getPostcode())
            $this->setPostcode($user->getPostcode());

        if ($this->city !== $user->getCity())
            $this->setCity($user->getCity());

        if ($this->phone !== $user->getPhone())
            $this->setPhone($user->getPhone());

        if ($this->favorite_recipes !== $user->getFavoriteRecipes())
            $this->setFavoriteRecipes($user->getFavoriteRecipes());
    }

    public function setName($name)
    {
        $this->name = strtolower(trim(htmlspecialchars($name)));
    }

    public function setFirstName($fname)
    {
        $this->fname = strtolower(trim(htmlspecialchars($fname)));
    }

    public function setGender($gender)
    {
        $this->gender = strtolower(trim(htmlspecialchars($gender)));
    }

    public function setEmail($email)
    {
        $this->email = strtolower(trim(htmlspecialchars($email)));
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = strtolower(trim(htmlspecialchars($birthdate)));
    }

    public function setAddress($address)
    {
        $this->address = strtolower(trim(htmlspecialchars($address)));
    }

    public function setPostcode($postcode)
    {
        $this->postcode = strtolower(trim(htmlspecialchars($postcode)));
    }

    public function setCity($city)
    {
        $this->city = strtolower(trim(htmlspecialchars($city)));
    }

    public function setPhone($phone)
    {
        $this->phone = strtolower(trim(htmlspecialchars($phone)));
    }

    public function setFavoriteRecipes($favorite_recipes)
    {
        $this->favorite_recipes = $favorite_recipes;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstName()
    {
        return $this->fname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getFavoriteRecipes()
    {
        return $this->favorite_recipes;
    }
}

/**
 * getJsonData
 *
 * Get the JSON File
 *
 * @return Array The JSON file
 */
function getJsonData()
{
    $jsonData = file_exists(__DIR__ . "/../data.json") ? json_decode(file_get_contents(__DIR__ . "/../data.json"), true) : [];
    if (empty($jsonData)) {
        $jsonData = [];
    }

    return $jsonData;
}

/**
 * setJsonData
 *
 * Replace the JSON file by the given data
 * @param mixed $data The data to convert to JSON
 * @return Array The JSON file
 */
function setJsonData($data)
{
    file_put_contents(__DIR__ . "/../data.json", json_encode($data));
}

/**
 * userExists
 *
 * Check if a user with the login given exist
 *
 * @param  mixed $login The login of the user we want to retrieve
 * @return false|Array(Array,idx,value) False if user doesn't exist | Else an array with the list of all users, the index of the user and his value
 */
function userExists($login, $getValue = true)
{
    $jsonData = getJsonData();

    foreach ($jsonData as $key => $profil) {
        if ($profil['login'] === $login) {
            if ($getValue)
                return array('key' => $key, 'profil' => $profil);
            else
                return $key;
        }
    }
    return false;
}


/**
 * addUser
 *
 * Add a user to the json file then log him
 *
 * @param  mixed $user The user to add
 * @return void
 */
function addUser(User $user)
{
    $jsonData = getJsonData();

    array_push($jsonData, $user->jsonSerialize());
    setJsonData($jsonData);

    logUser($user);
}


/**
 * 
 * editUser
 * 
 * Edit the profile of a user with the given values
 * 
 * @param int id The of the user we want to modify
 * @param User modifiedProfile The new profile of the user
 * 
 * @return void
 * 
 */
function editUser(int $id, User $modifiedProfile)
{
    $jsonData = getJsonData();

    $user = User::fromArray($jsonData[$id]);
    $user->editProfile($modifiedProfile);

    $jsonData[$id] = $user->jsonSerialize();

    file_put_contents(__DIR__ . "/../data.json", json_encode($jsonData));

    $_SESSION['user']['name'] = $jsonData[$id]['name'];
    $_SESSION['user']['fname'] = $jsonData[$id]['fname'];
}


/**
 * 
 * saveFavoriteRecipes()
 * 
 * Update the list of favorite recipes of the connected User
 * 
 * @return false|void
 * 
 */
function saveFavoriteRecipes()
{
    if (!isset($_SESSION['user']['login']))
        return false;

    $userId = userExists($_SESSION['user']['login'], false);
    if ($userId === false) {
        return false;
    }
    $jsonData = getJsonData();

    $jsonData[$userId]['favorite_recipes'] = $_SESSION['user']['favorite_recipes'];

    setJsonData($jsonData);
}


/**
 * logUser
 *
 * Set session variables for the user
 * Only use when the user is confirmed to be logged in and check datas before using this function
 *
 * @param  mixed $user Data of the user to log
 * @return void
 */
function logUser(User $user)
{
    // Login is the minimum required data
    if ($user->getLogin() === '')
        return;
    $_SESSION['connected'] = true;
    $_SESSION['user']['login'] = $user->getLogin();
    $_SESSION['user']['name'] = $user->getName();
    $_SESSION['user']['fname'] = $user->getFirstName();
    $_SESSION['user']['favorite_recipes'] = $user->getFavoriteRecipes();

    // Add favorites to user favorites
    if (isset($_SESSION['favorite_recipes']) && count($_SESSION['favorite_recipes']) > 0) {
        foreach ($_SESSION['favorite_recipes'] as $value) {
            if (!in_array($value, $_SESSION['user']['favorite_recipes'])) {
                $_SESSION['user']['favorite_recipes'][] = $value;
            }
        }
        saveFavoriteRecipes();
        unset($_SESSION['favorite_recipes']);
    }
}

/**
 * isRecipeFavorite
 *
 * Set session variables for the user
 * Only use when the user is confirmed to be logged in and check datas before using this function
 *
 * @param  mixed $user Data of the user to log
 * @return void
 */
function isRecipeFavorite($id)
{
    // If connected and user has id in favorites recipes return true, else if favorites_recipes are set and id is in return true, else return false
    return (isset($_SESSION['connected'])
        && $_SESSION['connected'] === true
        && isset($_SESSION['user']['favorite_recipes'])
        && in_array($id, $_SESSION['user']['favorite_recipes']))
        || (isset($_SESSION['favorite_recipes'])
            && in_array($id, $_SESSION['favorite_recipes']));
}
