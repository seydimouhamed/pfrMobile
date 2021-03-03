import { Observable, throwError } from 'rxjs';
import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent } from '@angular/common/http';
import { catchError } from 'rxjs/operators';
import { AuthenticationService } from '../connexion/authentication.service';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor{
    constructor(private authenticationService: AuthenticationService) {}

    intercept( request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(request).pipe(catchError ( err => {
            if ( err.status === 401 ) {
                this.authenticationService.logOut();
               // location.reload(true);
            }

            const error = err.error.message || err.statusText;
            return throwError(error);
        }));
    }
}