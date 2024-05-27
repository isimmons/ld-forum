import Head from '@/tests/MockComponents/MockedHead.vue';
import { config } from '@vue/test-utils';
import { route } from 'ziggy-js';
// @ts-ignore yes Ziggy is there.
import { Ziggy } from '@/ziggy';

//mocking Ziggy
config.global.mocks.route = (name: string) => route(name, undefined, undefined, Ziggy);

config.global.components = {
  Head,
};




