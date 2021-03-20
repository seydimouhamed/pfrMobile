import { UserService } from './../services/user.service';
import {ActivatedRouteSnapshot, Resolve, RouterStateSnapshot} from '@angular/router';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import { User } from 'src/model/User';
const ID = 'id';
@Injectable({
  providedIn: 'root'
})
export class UseCurrentResolverService implements Resolve<User[]> {
  constructor(private userService: UserService) {}

  resolve(): Observable<User[]> | Promise<User[]> | User[] {
    const data = this.userService.getCurrentUser();
    console.log(data);
    return  data;
  }
}
