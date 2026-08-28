# Articles

Gestion des articles

## Afficher la liste des articles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/articlesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":13,"nbreItems":4,"filter_value":"consequatur","idSchool":6,"idSection":8,"type":"consumable","expired":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/articlesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 13,
    "nbreItems": 4,
    "filter_value": "consequatur",
    "idSchool": 6,
    "idSection": 8,
    "type": "consumable",
    "expired": false
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
    'http://localhost/api/articlesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 13,
            'nbreItems' => 4,
            'filter_value' => 'consequatur',
            'idSchool' => 6,
            'idSection' => 8,
            'type' => 'consumable',
            'expired' => false,
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
<div id="execution-results-POSTapi-articlesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-articlesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-articlesall"></code></pre>
</div>
<div id="execution-error-POSTapi-articlesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-articlesall"></code></pre>
</div>
<form id="form-POSTapi-articlesall" data-method="POST" data-path="api/articlesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-articlesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/articlesall</code></b>
</p>
<p>
<label id="auth-POSTapi-articlesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-articlesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-articlesall" data-component="body"  hidden>
<br>
The value must be one of <code>consumable</code> or <code>storable</code>.
</p>
<p>
<b><code>expired</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-articlesall" hidden><input type="radio" name="expired" value="true" data-endpoint="POSTapi-articlesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-articlesall" hidden><input type="radio" name="expired" value="false" data-endpoint="POSTapi-articlesall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer des articles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/articles" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"articles":[{"idSchool":1,"idSection":4,"name":"deserunt","type":"consumable","image":"error","price":527271020.96519154,"description":"nobis","unit_of_measurement":"cum","alert_quantity":1,"expiry_date":"2025-11-22T14:46:51+0000","container":"tenetur","container_unit":"sequi","container_quantity":18,"detail":"at","suppliers":[13,6]}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/articles"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "articles": [
        {
            "idSchool": 1,
            "idSection": 4,
            "name": "deserunt",
            "type": "consumable",
            "image": "error",
            "price": 527271020.96519154,
            "description": "nobis",
            "unit_of_measurement": "cum",
            "alert_quantity": 1,
            "expiry_date": "2025-11-22T14:46:51+0000",
            "container": "tenetur",
            "container_unit": "sequi",
            "container_quantity": 18,
            "detail": "at",
            "suppliers": [
                13,
                6
            ]
        }
    ]
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
    'http://localhost/api/articles',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'articles' => [
                [
                    'idSchool' => 1,
                    'idSection' => 4,
                    'name' => 'deserunt',
                    'type' => 'consumable',
                    'image' => 'error',
                    'price' => 527271020.96519154,
                    'description' => 'nobis',
                    'unit_of_measurement' => 'cum',
                    'alert_quantity' => 1,
                    'expiry_date' => '2025-11-22T14:46:51+0000',
                    'container' => 'tenetur',
                    'container_unit' => 'sequi',
                    'container_quantity' => 18,
                    'detail' => 'at',
                    'suppliers' => [
                        13,
                        6,
                    ],
                ],
            ],
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
<div id="execution-results-POSTapi-articles" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-articles"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-articles"></code></pre>
</div>
<div id="execution-error-POSTapi-articles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-articles"></code></pre>
</div>
<form id="form-POSTapi-articles" data-method="POST" data-path="api/articles" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-articles', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/articles</code></b>
</p>
<p>
<label id="auth-POSTapi-articles" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-articles" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>articles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>articles[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.idSchool" data-endpoint="POSTapi-articles" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.idSection" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="articles.0.name" data-endpoint="POSTapi-articles" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="articles.0.type" data-endpoint="POSTapi-articles" data-component="body" required  hidden>
<br>
The value must be one of <code>consumable</code> or <code>storable</code>.
</p>
<p>
<b><code>articles[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.image" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].price</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="articles.0.price" data-endpoint="POSTapi-articles" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.description" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].unit_of_measurement</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.unit_of_measurement" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].alert_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.alert_quantity" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].expiry_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.expiry_date" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>articles[].container</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.container" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].container_unit</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.container_unit" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].container_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.container_quantity" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].detail</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="articles.0.detail" data-endpoint="POSTapi-articles" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].suppliers</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="articles.0.suppliers.0" data-endpoint="POSTapi-articles" data-component="body" required  hidden>
<input type="number" name="articles.0.suppliers.1" data-endpoint="POSTapi-articles" data-component="body" hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher un article spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/articles/sit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/articles/sit"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/articles/sit',
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


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-articles--article-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-articles--article-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-articles--article-"></code></pre>
</div>
<div id="execution-error-GETapi-articles--article-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-articles--article-"></code></pre>
</div>
<form id="form-GETapi-articles--article-" data-method="GET" data-path="api/articles/{article}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-articles--article-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/articles/{article}</code></b>
</p>
<p>
<label id="auth-GETapi-articles--article-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-articles--article-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>article</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="article" data-endpoint="GETapi-articles--article-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier un article spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/articles/explicabo" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":14,"idSection":12,"name":"velit","type":"storable","image":"dolor","price":730971.500507752,"description":"tenetur","unit_of_measurement":"dignissimos","alert_quantity":20,"expiry_date":"2025-11-22T14:46:51+0000","container":"non","container_unit":"doloremque","container_quantity":1,"detail":"placeat"}'

```

```javascript
const url = new URL(
    "http://localhost/api/articles/explicabo"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 14,
    "idSection": 12,
    "name": "velit",
    "type": "storable",
    "image": "dolor",
    "price": 730971.500507752,
    "description": "tenetur",
    "unit_of_measurement": "dignissimos",
    "alert_quantity": 20,
    "expiry_date": "2025-11-22T14:46:51+0000",
    "container": "non",
    "container_unit": "doloremque",
    "container_quantity": 1,
    "detail": "placeat"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/articles/explicabo',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 14,
            'idSection' => 12,
            'name' => 'velit',
            'type' => 'storable',
            'image' => 'dolor',
            'price' => 730971.500507752,
            'description' => 'tenetur',
            'unit_of_measurement' => 'dignissimos',
            'alert_quantity' => 20,
            'expiry_date' => '2025-11-22T14:46:51+0000',
            'container' => 'non',
            'container_unit' => 'doloremque',
            'container_quantity' => 1,
            'detail' => 'placeat',
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
<div id="execution-results-PUTapi-articles--article-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-articles--article-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-articles--article-"></code></pre>
</div>
<div id="execution-error-PUTapi-articles--article-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-articles--article-"></code></pre>
</div>
<form id="form-PUTapi-articles--article-" data-method="PUT" data-path="api/articles/{article}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-articles--article-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/articles/{article}</code></b>
</p>
<p>
<label id="auth-PUTapi-articles--article-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-articles--article-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>article</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="article" data-endpoint="PUTapi-articles--article-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>
The value must be one of <code>consumable</code> or <code>storable</code>.
</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="price" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>unit_of_measurement</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="unit_of_measurement" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>alert_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="alert_quantity" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>expiry_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="expiry_date" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>container</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="container" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>container_unit</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="container_unit" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>container_quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="container_quantity" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>detail</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="detail" data-endpoint="PUTapi-articles--article-" data-component="body"  hidden>
<br>

</p>

</form>


## Fonction pour le multiple archivage des articles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/articles/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[13,16]}'

```

```javascript
const url = new URL(
    "http://localhost/api/articles/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        13,
        16
    ]
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
    'http://localhost/api/articles/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                13,
                16,
            ],
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
<div id="execution-results-POSTapi-articles-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-articles-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-articles-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-articles-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-articles-trash"></code></pre>
</div>
<form id="form-POSTapi-articles-trash" data-method="POST" data-path="api/articles/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-articles-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/articles/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-articles-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-articles-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-articles-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-articles-trash" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de restauration multiples des articles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/articles/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,13]}'

```

```javascript
const url = new URL(
    "http://localhost/api/articles/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
        13
    ]
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
    'http://localhost/api/articles/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
                13,
            ],
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
<div id="execution-results-POSTapi-articles-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-articles-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-articles-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-articles-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-articles-restore"></code></pre>
</div>
<form id="form-POSTapi-articles-restore" data-method="POST" data-path="api/articles/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-articles-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/articles/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-articles-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-articles-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-articles-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-articles-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des articles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/articles/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[12,14]}'

```

```javascript
const url = new URL(
    "http://localhost/api/articles/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        12,
        14
    ]
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
    'http://localhost/api/articles/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                12,
                14,
            ],
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
<div id="execution-results-POSTapi-articles-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-articles-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-articles-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-articles-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-articles-delete"></code></pre>
</div>
<form id="form-POSTapi-articles-delete" data-method="POST" data-path="api/articles/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-articles-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/articles/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-articles-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-articles-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-articles-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-articles-delete" data-component="body" hidden>
<br>

</p>

</form>



