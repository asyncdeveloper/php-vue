# Design Doc

## How would you scale it ?

#### `GET subscribers/{id}`

To prevent checking the database on every api call, we check the cache first if it presents we return the subscriber
When it is not present we make a query to fetch and save to cache.

#### `POST subscribers`

Due to the
constraint `you cannot upsert records, so you’ll have to check if the subscriber already exists in the database.`
A cache layer (redis) should be added to prevent checking the database on every insert. i.e When storing subscriber,
check if that subscriber is present in cache, when it is not a query is made, and we insert returned subscriber to cache
and then persist subscriber.

## How would you scale the above endpoints to handle 10 times the traffic? What challenges do you foresee?

#### Background Processing

When we create a new subscriber we can push the task to a `queue` and then have consumers pick it up and process it.
This allows us handle the creation asynchronously which in turn makes the response time faster.

#### Load Balancing

This allows us serve our applications from multiple web servers which we can then auto-scale (horizontal scaling)
depending on traffic.

#### Caching

Persisting data in a cache reduces how often we hit our database.

#### Database Improvements

A couple of tweaks can be made to tune our database (vertical scaling) and also optimize when we can such as using
indexes, using a buffer cache or even partition data. Another way to do this is to analyze our ORM/queries
and do away with queries running under the hood. One example of this is our `Model::paginate()`

#### Optimize Configuration files

I have made some tweaks to `nginx.conf` by increasing `worker_connections` and also using `opcache`. I believe it can
still be improved by making additional config to `nginx` and also `php-fpm` to handle a higher number of requests/sec

## Challenges

#### Cache

We need to pick the right caching strategy and also setting when the cache data expires as we simply cannot persist data
indefinitely(it will cost us money).

#### Data consistency

The more servers we add the more complexity we introduce. what happens when a job is processed and fails?
how do we handle retries? what happens when servers or even our load balancer goes down? how do we ensure it is
stateless so we can scale?

#### Error Handling

In a large system, errors are bound to occur therefore having tools in place to trace errors is important and also how
to recover gracefully from it.
