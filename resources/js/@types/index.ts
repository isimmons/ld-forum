export type PaginationLink = {
  label: string;
  url: string;
  active: boolean;
};

export type Topic = {
  id: number;
  name: string;
  slug: string;
};

export type Team = {
  id: number;
  name: string;
};

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

export type PaginationMeta = {
  links: Array<PaginationLink>;
  from: number;
  to: number;
  total: number;
  current_page: number;
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

export type CommentWithUser<T> = Partial<T> & { user: User };

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
