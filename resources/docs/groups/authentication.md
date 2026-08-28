# Authentication


## Log in the new user




> Example request:

```bash
curl -X POST \
    "http://localhost/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"username":"alias","password":"dolore"}'

```

```javascript
const url = new URL(
    "http://localhost/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "alias",
    "password": "dolore"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/login',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'username' => 'alias',
            'password' => 'dolore',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (404):

```json
{
    "success": false,
    "message": "Le nom d'utilisateur ou mot de passe est incorrect",
    "message_error": null
}
```
<div id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-login"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</div>
<div id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</div>
<form id="form-POSTapi-login" data-method="POST" data-path="api/login" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/login</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>

</p>

</form>


## Enregistrer un nouvel utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/register" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"accusantium","firstname":{},"placeofbirth":{},"situation":{},"repeater":{},"cni":{},"email":{},"whatsapp_number":{},"profession":{},"bank_name":{},"bank_rib":{},"number_days_off":{},"password":{},"username":{},"phone":{},"adresse":{},"mother":{},"tutor":{},"phone_2":{},"phone_3":{},"phone_4":{},"phone_5":{},"phone_6":{},"observation":"omnis","nationality":{},"gender":"qui","adresse_2":"dolorum","adresse_tutor":"veritatis","gender_2":"nobis","gender_tutor":"placeat","role":"quod","birthday":{},"city":{},"fit":{},"desease":{},"matricule":{},"country":{},"idCampus":11,"salary":{},"hourlyPrice":{},"grade":{},"anciennete":{},"num_cnps":"cupiditate","niu":"et","agence":"adipisci","service":"itaque","categorie":"tenetur","num_dipe":"voluptatem","date_embauche":"2025-11-22T14:46:30+0000","idMatter":2,"idParent":4,"idLevel":4,"idCycle":12,"idClasse":13,"idClasse2":4,"idClassePrincipal":10,"idOptionLevel":19,"idSchool":20,"idSection":2,"photo":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/register"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "accusantium",
    "firstname": {},
    "placeofbirth": {},
    "situation": {},
    "repeater": {},
    "cni": {},
    "email": {},
    "whatsapp_number": {},
    "profession": {},
    "bank_name": {},
    "bank_rib": {},
    "number_days_off": {},
    "password": {},
    "username": {},
    "phone": {},
    "adresse": {},
    "mother": {},
    "tutor": {},
    "phone_2": {},
    "phone_3": {},
    "phone_4": {},
    "phone_5": {},
    "phone_6": {},
    "observation": "omnis",
    "nationality": {},
    "gender": "qui",
    "adresse_2": "dolorum",
    "adresse_tutor": "veritatis",
    "gender_2": "nobis",
    "gender_tutor": "placeat",
    "role": "quod",
    "birthday": {},
    "city": {},
    "fit": {},
    "desease": {},
    "matricule": {},
    "country": {},
    "idCampus": 11,
    "salary": {},
    "hourlyPrice": {},
    "grade": {},
    "anciennete": {},
    "num_cnps": "cupiditate",
    "niu": "et",
    "agence": "adipisci",
    "service": "itaque",
    "categorie": "tenetur",
    "num_dipe": "voluptatem",
    "date_embauche": "2025-11-22T14:46:30+0000",
    "idMatter": 2,
    "idParent": 4,
    "idLevel": 4,
    "idCycle": 12,
    "idClasse": 13,
    "idClasse2": 4,
    "idClassePrincipal": 10,
    "idOptionLevel": 19,
    "idSchool": 20,
    "idSection": 2,
    "photo": {}
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'accusantium',
            'firstname' => [],
            'placeofbirth' => [],
            'situation' => [],
            'repeater' => [],
            'cni' => [],
            'email' => [],
            'whatsapp_number' => [],
            'profession' => [],
            'bank_name' => [],
            'bank_rib' => [],
            'number_days_off' => [],
            'password' => [],
            'username' => [],
            'phone' => [],
            'adresse' => [],
            'mother' => [],
            'tutor' => [],
            'phone_2' => [],
            'phone_3' => [],
            'phone_4' => [],
            'phone_5' => [],
            'phone_6' => [],
            'observation' => 'omnis',
            'nationality' => [],
            'gender' => 'qui',
            'adresse_2' => 'dolorum',
            'adresse_tutor' => 'veritatis',
            'gender_2' => 'nobis',
            'gender_tutor' => 'placeat',
            'role' => 'quod',
            'birthday' => [],
            'city' => [],
            'fit' => [],
            'desease' => [],
            'matricule' => [],
            'country' => [],
            'idCampus' => 11,
            'salary' => [],
            'hourlyPrice' => [],
            'grade' => [],
            'anciennete' => [],
            'num_cnps' => 'cupiditate',
            'niu' => 'et',
            'agence' => 'adipisci',
            'service' => 'itaque',
            'categorie' => 'tenetur',
            'num_dipe' => 'voluptatem',
            'date_embauche' => '2025-11-22T14:46:30+0000',
            'idMatter' => 2,
            'idParent' => 4,
            'idLevel' => 4,
            'idCycle' => 12,
            'idClasse' => 13,
            'idClasse2' => 4,
            'idClassePrincipal' => 10,
            'idOptionLevel' => 19,
            'idSchool' => 20,
            'idSection' => 2,
            'photo' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (422):

```json
{
    "success": false,
    "message": "La valeur du champ adresse email est déjà utilisée. La valeur du champ téléphone est déjà utilisée. La valeur du champ matricule est déjà utilisée."
}
```
<div id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-register"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
</div>
<div id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register"></code></pre>
</div>
<form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/register</code></b>
</p>
<p>
<label id="auth-POSTapi-register" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-register" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>firstname</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="firstname" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>placeofbirth</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="placeofbirth" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>situation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="situation" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>repeater</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="repeater" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>cni</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="cni" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>whatsapp_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="whatsapp_number" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>profession</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="profession" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bank_name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bank_name" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bank_rib</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bank_rib" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>number_days_off</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="number_days_off" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="adresse" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>mother</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mother" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tutor</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tutor" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone_2</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone_2" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone_3</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone_3" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone_4</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone_4" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone_5</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone_5" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone_6</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="phone_6" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>observation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="observation" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nationality</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nationality" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="gender" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>adresse_2</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="adresse_2" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>adresse_tutor</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="adresse_tutor" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>gender_2</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="gender_2" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>gender_tutor</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="gender_tutor" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>role</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="role" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>birthday</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="birthday" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>city</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="city" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>fit</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="fit" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>desease</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="desease" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>matricule</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="matricule" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>country</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="country" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idCampus</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCampus" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>salary</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="salary" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>hourlyPrice</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="hourlyPrice" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>grade</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="grade" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>anciennete</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="anciennete" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>num_cnps</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="num_cnps" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>niu</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="niu" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>agence</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="agence" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>service</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="service" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>categorie</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="categorie" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>num_dipe</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="num_dipe" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_embauche</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_embauche" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idParent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idParent" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idCycle</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCycle" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse2</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse2" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClassePrincipal</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClassePrincipal" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>photo</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="photo" data-endpoint="POSTapi-register" data-component="body"  hidden>
<br>

</p>

</form>


## api/uploadphotos

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/uploadphotos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/uploadphotos"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/uploadphotos',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (500):

```json
{
    "message": "Call to a member function getClientOriginalName() on null",
    "exception": "Error",
    "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/app\/Http\/Controllers\/Auth\/RegisterController.php",
    "line": 94,
    "trace": [
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php",
            "line": 54,
            "function": "uploadphotos",
            "class": "App\\Http\\Controllers\\Auth\\RegisterController",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php",
            "line": 45,
            "function": "callAction",
            "class": "Illuminate\\Routing\\Controller",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
            "line": 239,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\ControllerDispatcher",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
            "line": 196,
            "function": "runController",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 685,
            "function": "run",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/app\/Http\/Middleware\/RedirectIfAuthenticated.php",
            "line": 25,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "App\\Http\\Middleware\\RedirectIfAuthenticated",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/app\/Http\/Middleware\/LogApiRequestsMiddleware.php",
            "line": 27,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "App\\Http\\Middleware\\LogApiRequestsMiddleware",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/SubstituteBindings.php",
            "line": 41,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\SubstituteBindings",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
            "line": 59,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php",
            "line": 33,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Laravel\\Sanctum\\Http\\Middleware\\{closure}",
            "class": "Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/sanctum\/src\/Http\/Middleware\/EnsureFrontendRequestsAreStateful.php",
            "line": 34,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 687,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 662,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 628,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 617,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 165,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 63,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php",
            "line": 52,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fruitcake\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 140,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 109,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 324,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 305,
            "function": "callLaravelOrLumenRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 76,
            "function": "makeApiCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 51,
            "function": "makeResponseCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 41,
            "function": "makeResponseCallIfEnabledAndNoSuccessResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 236,
            "function": "__invoke",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 172,
            "function": "iterateThroughStrategies",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 127,
            "function": "fetchResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 119,
            "function": "processRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 73,
            "function": "processRoutes",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 36,
            "function": "handle",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php",
            "line": 37,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 93,
            "function": "unwrapIfClosure",
            "class": "Illuminate\\Container\\Util",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 37,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 596,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 134,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 298,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 121,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 1040,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 301,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 171,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 93,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 129,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```
<div id="execution-results-POSTapi-uploadphotos" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-uploadphotos"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-uploadphotos"></code></pre>
</div>
<div id="execution-error-POSTapi-uploadphotos" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-uploadphotos"></code></pre>
</div>
<form id="form-POSTapi-uploadphotos" data-method="POST" data-path="api/uploadphotos" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-uploadphotos', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/uploadphotos</code></b>
</p>
<p>
<label id="auth-POSTapi-uploadphotos" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-uploadphotos" data-component="header"></label>
</p>
</form>


## Déconnecter l&#039;utilisateur connecté




> Example request:

```bash
curl -X POST \
    "http://localhost/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"token":"nostrum"}'

```

```javascript
const url = new URL(
    "http://localhost/api/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "token": "nostrum"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/logout',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'token' => 'nostrum',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-logout"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"></code></pre>
</div>
<div id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout"></code></pre>
</div>
<form id="form-POSTapi-logout" data-method="POST" data-path="api/logout" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/logout</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="token" data-endpoint="POSTapi-logout" data-component="body"  hidden>
<br>

</p>

</form>



