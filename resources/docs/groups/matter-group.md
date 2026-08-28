# Matter Group


## Afficher la liste des groupes de matières

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mattergroupsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":19,"idSection":10}'

```

```javascript
const url = new URL(
    "http://localhost/api/mattergroupsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 19,
    "idSection": 10
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
    'http://localhost/api/mattergroupsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 19,
            'idSection' => 10,
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
<div id="execution-results-POSTapi-mattergroupsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mattergroupsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mattergroupsall"></code></pre>
</div>
<div id="execution-error-POSTapi-mattergroupsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mattergroupsall"></code></pre>
</div>
<form id="form-POSTapi-mattergroupsall" data-method="POST" data-path="api/mattergroupsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mattergroupsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mattergroupsall</code></b>
</p>
<p>
<label id="auth-POSTapi-mattergroupsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mattergroupsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-mattergroupsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-mattergroupsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les infos d&#039;un groupe de matière

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/mattergroups/ducimus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/mattergroups/ducimus"
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
    'http://localhost/api/mattergroups/ducimus',
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
<div id="execution-results-GETapi-mattergroups--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-mattergroups--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-mattergroups--id-"></code></pre>
</div>
<div id="execution-error-GETapi-mattergroups--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-mattergroups--id-"></code></pre>
</div>
<form id="form-GETapi-mattergroups--id-" data-method="GET" data-path="api/mattergroups/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-mattergroups--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/mattergroups/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-mattergroups--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-mattergroups--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-mattergroups--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un Groupe de matières

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mattergroups" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptates","levels":"qui","matter":"voluptatem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/mattergroups"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptates",
    "levels": "qui",
    "matter": "voluptatem"
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
    'http://localhost/api/mattergroups',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'voluptates',
            'levels' => 'qui',
            'matter' => 'voluptatem',
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
<div id="execution-results-POSTapi-mattergroups" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mattergroups"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mattergroups"></code></pre>
</div>
<div id="execution-error-POSTapi-mattergroups" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mattergroups"></code></pre>
</div>
<form id="form-POSTapi-mattergroups" data-method="POST" data-path="api/mattergroups" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mattergroups', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mattergroups</code></b>
</p>
<p>
<label id="auth-POSTapi-mattergroups" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mattergroups" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-mattergroups" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="levels" data-endpoint="POSTapi-mattergroups" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>matter</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="matter" data-endpoint="POSTapi-mattergroups" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;un groupe de matières

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/mattergroups/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"temporibus","levels":"saepe","matter":"nam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/mattergroups/qui"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "temporibus",
    "levels": "saepe",
    "matter": "nam"
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
    'http://localhost/api/mattergroups/qui',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'temporibus',
            'levels' => 'saepe',
            'matter' => 'nam',
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
<div id="execution-results-PUTapi-mattergroups--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-mattergroups--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-mattergroups--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-mattergroups--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-mattergroups--id-"></code></pre>
</div>
<form id="form-PUTapi-mattergroups--id-" data-method="PUT" data-path="api/mattergroups/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-mattergroups--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/mattergroups/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-mattergroups--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-mattergroups--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-mattergroups--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-mattergroups--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>levels</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="levels" data-endpoint="PUTapi-mattergroups--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>matter</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="matter" data-endpoint="PUTapi-mattergroups--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Suppression d&#039;un groupe de matières

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/mattergroups/iusto" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/mattergroups/iusto"
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
    'http://localhost/api/mattergroups/iusto',
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
<div id="execution-results-DELETEapi-mattergroups--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-mattergroups--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-mattergroups--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-mattergroups--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-mattergroups--id-"></code></pre>
</div>
<form id="form-DELETEapi-mattergroups--id-" data-method="DELETE" data-path="api/mattergroups/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-mattergroups--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/mattergroups/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-mattergroups--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-mattergroups--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-mattergroups--id-" data-component="url" required  hidden>
<br>

</p>
</form>



