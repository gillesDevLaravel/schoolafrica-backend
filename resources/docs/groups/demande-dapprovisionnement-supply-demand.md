# Demande d'approvisionnement | Supply demand
Contrôleur chargé de la gestion des demandes d'approvisionnement.

## Affiche la liste paginée des demandes d&#039;approvisionnement, avec filtres optionnels.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/supply-demandsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"maiores","responsible_id":12,"hotel_id":15,"priority":"medium","status":"pending","article_ids":[8,14]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demandsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "maiores",
    "responsible_id": 12,
    "hotel_id": 15,
    "priority": "medium",
    "status": "pending",
    "article_ids": [
        8,
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
    'http://localhost/api/supply-demandsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'maiores',
            'responsible_id' => 12,
            'hotel_id' => 15,
            'priority' => 'medium',
            'status' => 'pending',
            'article_ids' => [
                8,
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
<div id="execution-results-POSTapi-supply-demandsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-supply-demandsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-supply-demandsall"></code></pre>
</div>
<div id="execution-error-POSTapi-supply-demandsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-supply-demandsall"></code></pre>
</div>
<form id="form-POSTapi-supply-demandsall" data-method="POST" data-path="api/supply-demandsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-supply-demandsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/supply-demandsall</code></b>
</p>
<p>
<label id="auth-POSTapi-supply-demandsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-supply-demandsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="responsible_id" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>hotel_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="hotel_id" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="priority" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<br>
The value must be one of <code>high</code>, <code>medium</code>, or <code>low</code>.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<br>
The value must be one of <code>pending</code>, <code>accepted</code>, or <code>refused</code>.
</p>
<p>
<b><code>article_ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="article_ids.0" data-endpoint="POSTapi-supply-demandsall" data-component="body"  hidden>
<input type="number" name="article_ids.1" data-endpoint="POSTapi-supply-demandsall" data-component="body" hidden>
<br>

</p>

</form>


## Crée une nouvelle demande d&#039;approvisionnement.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/supply-demands" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"consequuntur","description":"vero","responsible_id":18,"priority":"low","status":"refused","articles":[{"id":15,"unit_price":8,"quantity":3,"supplier_id":12}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "consequuntur",
    "description": "vero",
    "responsible_id": 18,
    "priority": "low",
    "status": "refused",
    "articles": [
        {
            "id": 15,
            "unit_price": 8,
            "quantity": 3,
            "supplier_id": 12
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
    'http://localhost/api/supply-demands',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'consequuntur',
            'description' => 'vero',
            'responsible_id' => 18,
            'priority' => 'low',
            'status' => 'refused',
            'articles' => [
                [
                    'id' => 15,
                    'unit_price' => 8,
                    'quantity' => 3,
                    'supplier_id' => 12,
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
<div id="execution-results-POSTapi-supply-demands" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-supply-demands"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-supply-demands"></code></pre>
</div>
<div id="execution-error-POSTapi-supply-demands" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-supply-demands"></code></pre>
</div>
<form id="form-POSTapi-supply-demands" data-method="POST" data-path="api/supply-demands" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-supply-demands', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/supply-demands</code></b>
</p>
<p>
<label id="auth-POSTapi-supply-demands" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-supply-demands" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-supply-demands" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-supply-demands" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="responsible_id" data-endpoint="POSTapi-supply-demands" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="priority" data-endpoint="POSTapi-supply-demands" data-component="body"  hidden>
<br>
The value must be one of <code>high</code>, <code>medium</code>, or <code>low</code>.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-supply-demands" data-component="body"  hidden>
<br>
The value must be one of <code>pending</code>, <code>accepted</code>, or <code>refused</code>.
</p>
<p>
<details>
<summary>
<b><code>articles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>articles[].id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.id" data-endpoint="POSTapi-supply-demands" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].unit_price</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.unit_price" data-endpoint="POSTapi-supply-demands" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.quantity" data-endpoint="POSTapi-supply-demands" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].supplier_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.supplier_id" data-endpoint="POSTapi-supply-demands" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Affiche les détails d&#039;une demande d&#039;approvisionnement spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/supply-demands/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands/sint"
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
    'http://localhost/api/supply-demands/sint',
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
<div id="execution-results-GETapi-supply-demands--supply_demand-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-supply-demands--supply_demand-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-supply-demands--supply_demand-"></code></pre>
</div>
<div id="execution-error-GETapi-supply-demands--supply_demand-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-supply-demands--supply_demand-"></code></pre>
</div>
<form id="form-GETapi-supply-demands--supply_demand-" data-method="GET" data-path="api/supply-demands/{supply_demand}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-supply-demands--supply_demand-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/supply-demands/{supply_demand}</code></b>
</p>
<p>
<label id="auth-GETapi-supply-demands--supply_demand-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-supply-demands--supply_demand-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>supply_demand</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="supply_demand" data-endpoint="GETapi-supply-demands--supply_demand-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour les informations d&#039;une demande d&#039;approvisionnement existante.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/supply-demands/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"sed","description":"tempora","responsible_id":6,"priority":"medium","status":"pending","articles":[{"id":5,"unit_price":17,"quantity":15,"supplier_id":8}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands/qui"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "sed",
    "description": "tempora",
    "responsible_id": 6,
    "priority": "medium",
    "status": "pending",
    "articles": [
        {
            "id": 5,
            "unit_price": 17,
            "quantity": 15,
            "supplier_id": 8
        }
    ]
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
    'http://localhost/api/supply-demands/qui',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'sed',
            'description' => 'tempora',
            'responsible_id' => 6,
            'priority' => 'medium',
            'status' => 'pending',
            'articles' => [
                [
                    'id' => 5,
                    'unit_price' => 17,
                    'quantity' => 15,
                    'supplier_id' => 8,
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
<div id="execution-results-PUTapi-supply-demands--supply_demand-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-supply-demands--supply_demand-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-supply-demands--supply_demand-"></code></pre>
</div>
<div id="execution-error-PUTapi-supply-demands--supply_demand-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-supply-demands--supply_demand-"></code></pre>
</div>
<form id="form-PUTapi-supply-demands--supply_demand-" data-method="PUT" data-path="api/supply-demands/{supply_demand}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-supply-demands--supply_demand-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/supply-demands/{supply_demand}</code></b>
</p>
<p>
<label id="auth-PUTapi-supply-demands--supply_demand-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>supply_demand</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="supply_demand" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="responsible_id" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="priority" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>
The value must be one of <code>high</code>, <code>medium</code>, or <code>low</code>.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>
The value must be one of <code>pending</code>, <code>accepted</code>, or <code>refused</code>.
</p>
<p>
<details>
<summary>
<b><code>articles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>articles[].id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.id" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].unit_price</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.unit_price" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.quantity" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].supplier_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.supplier_id" data-endpoint="PUTapi-supply-demands--supply_demand-" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Met en corbeille (suppression logique) une ou plusieurs demandes d&#039;approvisionnement.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/supply-demands/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[12,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        12,
        11
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
    'http://localhost/api/supply-demands/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                12,
                11,
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
<div id="execution-results-POSTapi-supply-demands-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-supply-demands-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-supply-demands-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-supply-demands-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-supply-demands-trash"></code></pre>
</div>
<form id="form-POSTapi-supply-demands-trash" data-method="POST" data-path="api/supply-demands/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-supply-demands-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/supply-demands/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-supply-demands-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-supply-demands-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-supply-demands-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-supply-demands-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure une ou plusieurs demandes d&#039;approvisionnement supprimées (suppression logique).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/supply-demands/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[5,18]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        5,
        18
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
    'http://localhost/api/supply-demands/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                5,
                18,
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
<div id="execution-results-POSTapi-supply-demands-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-supply-demands-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-supply-demands-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-supply-demands-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-supply-demands-restore"></code></pre>
</div>
<form id="form-POSTapi-supply-demands-restore" data-method="POST" data-path="api/supply-demands/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-supply-demands-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/supply-demands/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-supply-demands-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-supply-demands-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-supply-demands-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-supply-demands-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement une ou plusieurs demandes d&#039;approvisionnement.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/supply-demands/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,10]}'

```

```javascript
const url = new URL(
    "http://localhost/api/supply-demands/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
        10
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
    'http://localhost/api/supply-demands/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
                10,
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
<div id="execution-results-POSTapi-supply-demands-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-supply-demands-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-supply-demands-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-supply-demands-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-supply-demands-delete"></code></pre>
</div>
<form id="form-POSTapi-supply-demands-delete" data-method="POST" data-path="api/supply-demands/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-supply-demands-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/supply-demands/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-supply-demands-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-supply-demands-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-supply-demands-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-supply-demands-delete" data-component="body" hidden>
<br>

</p>

</form>



