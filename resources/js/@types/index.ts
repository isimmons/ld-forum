// inertia/jetstream auth.user
// need to separate out plain user  from the other stuff and use helper to combine when needed
// but this works for the app as is at this point
export type User = {
  id: number;
  name: string;
  username: string;
  email: string;
  profile_photo_path: string;
  profile_photo_url: string;
  two_factor_enabled: boolean;
  two_factor_confirmed_at: Date | null;
  email_verified_at: Date | null;
  created_at: Date;
  updated_at: Date;
  current_team_id: number | null;
  current_team: string;
  all_teams: Array<Team>;
};

// define the type of the pagination data. Should be the same for all models
export type PaginationLink = {
  label: string;
  url: string;
  active: boolean;
};

export type PaginationMeta = {
  links: Array<PaginationLink>;
  from: number;
  to: number;
  total: number;
  current_page: number;
};

// The shared props that can be accessed via usePage()
// May be more. Adding these as needed. Works for app at this point
export type InertiaSharedProps = {
  auth: { user: User };
  permissions: { create_posts: boolean };
  jetstream: {
    hasApiFeatures: boolean;
    hasTeamFeatures: boolean;
    hasAccountDeletionFeatures: boolean;
    hasEmailVerification: boolean;
    managesProfilePhotos: boolean;
    canCreateTeams: boolean;
    canUpdateProfileInformation: boolean;
    canManageTwoFactorAuthentication: boolean;
    canUpdatePassword: boolean;
    flash: {
      bannerStyle?: 'success' | 'danger';
      banner?: string;
      delay?: number;
    };
  };
};

// for the jetstream profile 2FA setup
export type TwoFASession = {
  agent: {
    is_desktop: boolean;
    platform: string;
    browser: string;
  };
  ip_address: string;
  is_current_device: boolean;
  last_active: Date;
};

// still need type in code even though not using teams at this point
export type Team = {
  id: number;
  name: string;
};

export type Topic = {
  id: number;
  name: string;
  slug: string;
};

export type Post = {
  id: number;
  title: string;
  body: string;
  created_at: string;
  updated_at: string;
  routes: { show: string };
  topic: Topic;
  user: User;
  html: string;
};

export type Comment = {
  id: number;
  title: string;
  body: string;
  html: string;
  created_at: string;
  updated_at: string;
  can?: {
    update: boolean;
    delete: boolean;
  };
};

// helper to include user in the comment
// Will make more helpers as I separate out some of the types above
// like PostWithOtherStuff
// Usage: CommentWithUser<Comment>; returns a Comment with added user property
export type CommentWithUser<T> = Partial<T> & { user: User };
