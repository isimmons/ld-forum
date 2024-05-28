import { config } from '@vue/test-utils';
import { route } from 'ziggy-js';
// @ts-ignore yes Ziggy is there.
import { Ziggy } from '@/ziggy';
import { Link } from '@inertiajs/vue3';
import { createHeadManager } from '@inertiajs/core';

//mocking Ziggy
config.global.mocks.route = (name: string) =>
  route(name, undefined, undefined, Ziggy);

// fixes inertia Links showing up as <link-stub> in the component.html()
config.global.stubs = {
  Link,
};

// fixes TypeError: Cannot read properties of undefined (reading 'createProvider')
const mockedHeadManager = createHeadManager(
  false,
  () => '',
  () => '',
);
config.global.mocks.$headManager = mockedHeadManager;
