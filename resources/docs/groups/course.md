# Course


## Lister les cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/coursesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":13,"idSection":2,"idLevel":11,"idPiece":14,"idClasse":5,"idTeacher":11,"date_start":{},"date":{},"date_end":{},"filter_value":{},"pageItems":3,"nbreItems":16,"jour":"repellat","filterUniqueCourses":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/coursesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 13,
    "idSection": 2,
    "idLevel": 11,
    "idPiece": 14,
    "idClasse": 5,
    "idTeacher": 11,
    "date_start": {},
    "date": {},
    "date_end": {},
    "filter_value": {},
    "pageItems": 3,
    "nbreItems": 16,
    "jour": "repellat",
    "filterUniqueCourses": false
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
    'http://localhost/api/coursesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 13,
            'idSection' => 2,
            'idLevel' => 11,
            'idPiece' => 14,
            'idClasse' => 5,
            'idTeacher' => 11,
            'date_start' => [],
            'date' => [],
            'date_end' => [],
            'filter_value' => [],
            'pageItems' => 3,
            'nbreItems' => 16,
            'jour' => 'repellat',
            'filterUniqueCourses' => false,
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
<div id="execution-results-POSTapi-coursesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-coursesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-coursesall"></code></pre>
</div>
<div id="execution-error-POSTapi-coursesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-coursesall"></code></pre>
</div>
<form id="form-POSTapi-coursesall" data-method="POST" data-path="api/coursesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-coursesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/coursesall</code></b>
</p>
<p>
<label id="auth-POSTapi-coursesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-coursesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-coursesall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPiece</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPiece" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>jour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="jour" data-endpoint="POSTapi-coursesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filterUniqueCourses</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-coursesall" hidden><input type="radio" name="filterUniqueCourses" value="true" data-endpoint="POSTapi-coursesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-coursesall" hidden><input type="radio" name="filterUniqueCourses" value="false" data-endpoint="POSTapi-coursesall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Afficher les infos d&#039;un cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/courses/esse" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/courses/esse"
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
    'http://localhost/api/courses/esse',
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
<div id="execution-results-GETapi-courses--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-courses--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-courses--id-"></code></pre>
</div>
<div id="execution-error-GETapi-courses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-courses--id-"></code></pre>
</div>
<form id="form-GETapi-courses--id-" data-method="GET" data-path="api/courses/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-courses--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/courses/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-courses--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-courses--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-courses--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un nouveau cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/courses" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"hour":"ut","duration":"numquam","day":"quaerat","idMatter":6,"idClasse":19,"idTeacher":3,"idSchool":5,"idSection":1,"idLevel":13,"idPiece":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/courses"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "hour": "ut",
    "duration": "numquam",
    "day": "quaerat",
    "idMatter": 6,
    "idClasse": 19,
    "idTeacher": 3,
    "idSchool": 5,
    "idSection": 1,
    "idLevel": 13,
    "idPiece": 2
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
    'http://localhost/api/courses',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'hour' => 'ut',
            'duration' => 'numquam',
            'day' => 'quaerat',
            'idMatter' => 6,
            'idClasse' => 19,
            'idTeacher' => 3,
            'idSchool' => 5,
            'idSection' => 1,
            'idLevel' => 13,
            'idPiece' => 2,
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
<div id="execution-results-POSTapi-courses" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-courses"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-courses"></code></pre>
</div>
<div id="execution-error-POSTapi-courses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-courses"></code></pre>
</div>
<form id="form-POSTapi-courses" data-method="POST" data-path="api/courses" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-courses', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/courses</code></b>
</p>
<p>
<label id="auth-POSTapi-courses" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-courses" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>hour</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="hour" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="duration" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>day</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="day" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-courses" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-courses" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-courses" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-courses" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPiece</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPiece" data-endpoint="POSTapi-courses" data-component="body"  hidden>
<br>

</p>

</form>


## api/coursesduplicate

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/coursesduplicate" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cours_id":[18,18],"idClasse":17,"idTeacher":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/coursesduplicate"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cours_id": [
        18,
        18
    ],
    "idClasse": 17,
    "idTeacher": 2
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
    'http://localhost/api/coursesduplicate',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'cours_id' => [
                18,
                18,
            ],
            'idClasse' => 17,
            'idTeacher' => 2,
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
<div id="execution-results-POSTapi-coursesduplicate" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-coursesduplicate"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-coursesduplicate"></code></pre>
</div>
<div id="execution-error-POSTapi-coursesduplicate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-coursesduplicate"></code></pre>
</div>
<form id="form-POSTapi-coursesduplicate" data-method="POST" data-path="api/coursesduplicate" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-coursesduplicate', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/coursesduplicate</code></b>
</p>
<p>
<label id="auth-POSTapi-coursesduplicate" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-coursesduplicate" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>cours_id</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="cours_id.0" data-endpoint="POSTapi-coursesduplicate" data-component="body"  hidden>
<input type="number" name="cours_id.1" data-endpoint="POSTapi-coursesduplicate" data-component="body" hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-coursesduplicate" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-coursesduplicate" data-component="body" required  hidden>
<br>

</p>

</form>


## Ajouter plusieurs cours en un course

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/courses-bulk" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"courses":"ducimus"}'

```

```javascript
const url = new URL(
    "http://localhost/api/courses-bulk"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "courses": "ducimus"
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
    'http://localhost/api/courses-bulk',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'courses' => 'ducimus',
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
<div id="execution-results-POSTapi-courses-bulk" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-courses-bulk"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-courses-bulk"></code></pre>
</div>
<div id="execution-error-POSTapi-courses-bulk" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-courses-bulk"></code></pre>
</div>
<form id="form-POSTapi-courses-bulk" data-method="POST" data-path="api/courses-bulk" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-courses-bulk', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/courses-bulk</code></b>
</p>
<p>
<label id="auth-POSTapi-courses-bulk" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-courses-bulk" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>courses</code></b>&nbsp;&nbsp;<small>Array</small>     <i>optional</i> &nbsp;
<input type="text" name="courses" data-endpoint="POSTapi-courses-bulk" data-component="body"  hidden>
<br>
de cours à ajouter. Le format de chaque tableau est définit par POST /api/courses
</p>

</form>


## maj des infos d&#039;un cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/courses/eum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/courses/eum"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/courses/eum',
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
<div id="execution-results-PUTapi-courses--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-courses--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-courses--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-courses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-courses--id-"></code></pre>
</div>
<form id="form-PUTapi-courses--id-" data-method="PUT" data-path="api/courses/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-courses--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/courses/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-courses--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-courses--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-courses--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/courses/dolor" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/courses/dolor"
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
    'http://localhost/api/courses/dolor',
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
<div id="execution-results-DELETEapi-courses--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-courses--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-courses--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-courses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-courses--id-"></code></pre>
</div>
<form id="form-DELETEapi-courses--id-" data-method="DELETE" data-path="api/courses/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-courses--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/courses/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-courses--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-courses--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-courses--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer plusieurs cours

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/courses/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/courses/delete"
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
    'http://localhost/api/courses/delete',
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
<div id="execution-results-POSTapi-courses-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-courses-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-courses-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-courses-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-courses-delete"></code></pre>
</div>
<form id="form-POSTapi-courses-delete" data-method="POST" data-path="api/courses/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-courses-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/courses/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-courses-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-courses-delete" data-component="header"></label>
</p>
</form>



