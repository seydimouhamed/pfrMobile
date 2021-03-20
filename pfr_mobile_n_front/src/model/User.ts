import { Profil } from './Profil';

export class User{
    id?: number;
    firstname: string;
    email: string;
    lastname: string;
    password?: string;
    username: string;
    token?: any;
    profil: Profil;
    agence?: any;
}

