import { route as routeFn } from 'ziggy-js';
import { InertiaSharedProps } from '@/@types';

declare global {
  const route: typeof routeFn;
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    route: typeof routeFn;
  }
}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaSharedProps {}
}
