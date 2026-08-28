# Suggestions / Suggestions

Gestion des Suggestions

## Afficher la liste des suggestions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/suggestionsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"qui","nbreItems":10,"pageItems":14,"user_id":7,"isAnonymous":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestionsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "qui",
    "nbreItems": 10,
    "pageItems": 14,
    "user_id": 7,
    "isAnonymous": false
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
    'http://localhost/api/suggestionsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'qui',
            'nbreItems' => 10,
            'pageItems' => 14,
            'user_id' => 7,
            'isAnonymous' => false,
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
<div id="execution-results-POSTapi-suggestionsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-suggestionsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-suggestionsall"></code></pre>
</div>
<div id="execution-error-POSTapi-suggestionsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-suggestionsall"></code></pre>
</div>
<form id="form-POSTapi-suggestionsall" data-method="POST" data-path="api/suggestionsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-suggestionsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/suggestionsall</code></b>
</p>
<p>
<label id="auth-POSTapi-suggestionsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-suggestionsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-suggestionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-suggestionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-suggestionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-suggestionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>isAnonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-suggestionsall" hidden><input type="radio" name="isAnonymous" value="true" data-endpoint="POSTapi-suggestionsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-suggestionsall" hidden><input type="radio" name="isAnonymous" value="false" data-endpoint="POSTapi-suggestionsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Ajouter une nouvelle suggestion

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/suggestions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptas","description":"maxime","user_id":19,"isAnonymous":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptas",
    "description": "maxime",
    "user_id": 19,
    "isAnonymous": false
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
    'http://localhost/api/suggestions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'voluptas',
            'description' => 'maxime',
            'user_id' => 19,
            'isAnonymous' => false,
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
<div id="execution-results-POSTapi-suggestions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-suggestions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-suggestions"></code></pre>
</div>
<div id="execution-error-POSTapi-suggestions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-suggestions"></code></pre>
</div>
<form id="form-POSTapi-suggestions" data-method="POST" data-path="api/suggestions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-suggestions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/suggestions</code></b>
</p>
<p>
<label id="auth-POSTapi-suggestions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-suggestions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-suggestions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-suggestions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-suggestions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>isAnonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-suggestions" hidden><input type="radio" name="isAnonymous" value="true" data-endpoint="POSTapi-suggestions" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-suggestions" hidden><input type="radio" name="isAnonymous" value="false" data-endpoint="POSTapi-suggestions" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Afficher une suggestion spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/suggestions/sit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/suggestions/sit"
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
    'http://localhost/api/suggestions/sit',
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
<div id="execution-results-GETapi-suggestions--suggestion-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-suggestions--suggestion-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-suggestions--suggestion-"></code></pre>
</div>
<div id="execution-error-GETapi-suggestions--suggestion-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-suggestions--suggestion-"></code></pre>
</div>
<form id="form-GETapi-suggestions--suggestion-" data-method="GET" data-path="api/suggestions/{suggestion}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-suggestions--suggestion-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/suggestions/{suggestion}</code></b>
</p>
<p>
<label id="auth-GETapi-suggestions--suggestion-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-suggestions--suggestion-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>suggestion</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="suggestion" data-endpoint="GETapi-suggestions--suggestion-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier une suggestion spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/suggestions/autem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptas","description":"omnis","user_id":18,"isAnonymous":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestions/autem"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptas",
    "description": "omnis",
    "user_id": 18,
    "isAnonymous": false
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
    'http://localhost/api/suggestions/autem',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'voluptas',
            'description' => 'omnis',
            'user_id' => 18,
            'isAnonymous' => false,
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
<div id="execution-results-PUTapi-suggestions--suggestion-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-suggestions--suggestion-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-suggestions--suggestion-"></code></pre>
</div>
<div id="execution-error-PUTapi-suggestions--suggestion-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-suggestions--suggestion-"></code></pre>
</div>
<form id="form-PUTapi-suggestions--suggestion-" data-method="PUT" data-path="api/suggestions/{suggestion}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-suggestions--suggestion-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/suggestions/{suggestion}</code></b>
</p>
<p>
<label id="auth-PUTapi-suggestions--suggestion-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-suggestions--suggestion-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>suggestion</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="suggestion" data-endpoint="PUTapi-suggestions--suggestion-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-suggestions--suggestion-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-suggestions--suggestion-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="PUTapi-suggestions--suggestion-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>isAnonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-suggestions--suggestion-" hidden><input type="radio" name="isAnonymous" value="true" data-endpoint="PUTapi-suggestions--suggestion-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-suggestions--suggestion-" hidden><input type="radio" name="isAnonymous" value="false" data-endpoint="PUTapi-suggestions--suggestion-" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Archivage multiple des suggestions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/suggestions/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[6,3]}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestions/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        6,
        3
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
    'http://localhost/api/suggestions/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                6,
                3,
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
<div id="execution-results-POSTapi-suggestions-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-suggestions-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-suggestions-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-suggestions-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-suggestions-trash"></code></pre>
</div>
<form id="form-POSTapi-suggestions-trash" data-method="POST" data-path="api/suggestions/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-suggestions-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/suggestions/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-suggestions-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-suggestions-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-suggestions-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-suggestions-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restauration multiple des rapports journaliers

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/suggestions/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[10,10]}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestions/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        10,
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
    'http://localhost/api/suggestions/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                10,
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
<div id="execution-results-POSTapi-suggestions-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-suggestions-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-suggestions-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-suggestions-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-suggestions-restore"></code></pre>
</div>
<form id="form-POSTapi-suggestions-restore" data-method="POST" data-path="api/suggestions/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-suggestions-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/suggestions/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-suggestions-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-suggestions-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-suggestions-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-suggestions-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/suggestions/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[17,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/suggestions/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        17,
        5
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
    'http://localhost/api/suggestions/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                17,
                5,
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
<div id="execution-results-POSTapi-suggestions-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-suggestions-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-suggestions-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-suggestions-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-suggestions-delete"></code></pre>
</div>
<form id="form-POSTapi-suggestions-delete" data-method="POST" data-path="api/suggestions/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-suggestions-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/suggestions/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-suggestions-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-suggestions-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-suggestions-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-suggestions-delete" data-component="body" hidden>
<br>

</p>

</form>



