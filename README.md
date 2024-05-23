# ld-forum
ld for Luke Downing
This is the build a forum project taught by Luke Downing on Laracasts.

## Notes
Validating integers with datasets, PHP has a bug where booleans and
floats pass as integers so the numeric validator is best to use.
See the Datasets file (topic_id)
[GH Issue With Link to PHP Docs](https://github.com/laravel/framework/issues/28685)

### Typescript
WIP converting to typescript.

Important files: tsconfig.json vite.config.ts, @types/index, js/ziggy files, js/d.ts files, package.json

A lot has been converted but still more to go. 

All tests pass at this point (manual visual tests, pest tests, typecheck, and vite build)

Places/people I got assistance from so far:

[laravel.io Alberto Rosas](https://laravel.io/articles/enhancing-laravel-and-inertiajs-with-typescript-and-vue-3s-composition-api-to-build-a-powerful-spa)
[laracasts discussions patrick_j and erbelion](https://laracasts.com/discuss/channels/javascript/how-to-strongly-type-inertiajs-usepage-hook)
[ziggy-js repo readme](https://github.com/tighten/ziggy)

Things need finishing

Things need refactoring

### UPDATE

Everything that can be TS is now TS
