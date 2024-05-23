import { route as routeFn } from 'ziggy-js';
import { InertiaSharedProps } from '@/@types';

declare global {
  var route: typeof routeFn;
}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaSharedProps {}
}
