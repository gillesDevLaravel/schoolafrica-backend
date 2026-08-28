# Event


## Afficher la liste des events

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/eventsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":17,"idSection":9,"classes":{},"levels":{},"type":"interne"}'

```

```javascript
const url = new URL(
    "http://localhost/api/eventsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 17,
    "idSection": 9,
    "classes": {},
    "levels": {},
    "type": "interne"
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
    'http://localhost/api/eventsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 17,
            'idSection' => 9,
            'classes' => [],
            'levels' => [],
            'type' => 'interne',
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
<div id="execution-results-POSTapi-eventsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-eventsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-eventsall"></code></pre>
</div>
<div id="execution-error-POSTapi-eventsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-eventsall"></code></pre>
</div>
<form id="form-POSTapi-eventsall" data-method="POST" data-path="api/eventsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-eventsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/eventsall</code></b>
</p>
<p>
<label id="auth-POSTapi-eventsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-eventsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-eventsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-eventsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="classes" data-endpoint="POSTapi-eventsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>levels</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="levels" data-endpoint="POSTapi-eventsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-eventsall" data-component="body"  hidden>
<br>
The value must be one of <code>interne</code> or <code>externe</code>.
</p>

</form>


## Afficher les détails d&#039;un event

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/events/quidem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/events/quidem"
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
    'http://localhost/api/events/quidem',
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
<div id="execution-results-GETapi-events--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-events--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-events--id-"></code></pre>
</div>
<div id="execution-error-GETapi-events--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-events--id-"></code></pre>
</div>
<form id="form-GETapi-events--id-" data-method="GET" data-path="api/events/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-events--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/events/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-events--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-events--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-events--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un event

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/events" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"minus","description":"ex","startDate":"eos","endDate":{},"type":"externe","idSchool":6,"idSection":2,"classes":{},"levels":{},"parentalContribution":{},"budget":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/events"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "minus",
    "description": "ex",
    "startDate": "eos",
    "endDate": {},
    "type": "externe",
    "idSchool": 6,
    "idSection": 2,
    "classes": {},
    "levels": {},
    "parentalContribution": {},
    "budget": {}
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
    'http://localhost/api/events',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'minus',
            'description' => 'ex',
            'startDate' => 'eos',
            'endDate' => [],
            'type' => 'externe',
            'idSchool' => 6,
            'idSection' => 2,
            'classes' => [],
            'levels' => [],
            'parentalContribution' => [],
            'budget' => [],
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
<div id="execution-results-POSTapi-events" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-events"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-events"></code></pre>
</div>
<div id="execution-error-POSTapi-events" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-events"></code></pre>
</div>
<form id="form-POSTapi-events" data-method="POST" data-path="api/events" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-events', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/events</code></b>
</p>
<p>
<label id="auth-POSTapi-events" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-events" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-events" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-events" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="startDate" data-endpoint="POSTapi-events" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="endDate" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-events" data-component="body" required  hidden>
<br>
The value must be one of <code>interne</code> or <code>externe</code>.
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-events" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="classes" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>levels</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="levels" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>parentalContribution</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="parentalContribution" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>budget</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="budget" data-endpoint="POSTapi-events" data-component="body"  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un event

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/events/eos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"cum","description":"atque","startDate":"voluptatem","endDate":{},"type":"interne","idSchool":3,"idSection":9,"classes":{},"levels":{},"parentalContribution":{},"budget":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/events/eos"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "cum",
    "description": "atque",
    "startDate": "voluptatem",
    "endDate": {},
    "type": "interne",
    "idSchool": 3,
    "idSection": 9,
    "classes": {},
    "levels": {},
    "parentalContribution": {},
    "budget": {}
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
    'http://localhost/api/events/eos',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'cum',
            'description' => 'atque',
            'startDate' => 'voluptatem',
            'endDate' => [],
            'type' => 'interne',
            'idSchool' => 3,
            'idSection' => 9,
            'classes' => [],
            'levels' => [],
            'parentalContribution' => [],
            'budget' => [],
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
<div id="execution-results-PUTapi-events--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-events--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-events--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-events--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-events--id-"></code></pre>
</div>
<form id="form-PUTapi-events--id-" data-method="PUT" data-path="api/events/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-events--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/events/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-events--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-events--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-events--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-events--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-events--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="startDate" data-endpoint="PUTapi-events--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="endDate" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-events--id-" data-component="body" required  hidden>
<br>
The value must be one of <code>interne</code> or <code>externe</code>.
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-events--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="classes" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>levels</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="levels" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>parentalContribution</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="parentalContribution" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>budget</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="budget" data-endpoint="PUTapi-events--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer un event

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/events/mollitia" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/events/mollitia"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/events/mollitia',
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
<div id="execution-results-DELETEapi-events--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-events--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-events--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-events--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-events--id-"></code></pre>
</div>
<form id="form-DELETEapi-events--id-" data-method="DELETE" data-path="api/events/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-events--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/events/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-events--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-events--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-events--id-" data-component="url" required  hidden>
<br>

</p>
</form>



