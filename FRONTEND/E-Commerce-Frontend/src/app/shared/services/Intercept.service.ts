import { AppService } from "./../../app.service";
import { Injectable } from "@angular/core";
import {
  HttpEvent,
  HttpInterceptor,
  HttpHandler,
  HttpRequest,
} from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError } from "rxjs/operators";
import { Router } from "@angular/router";
import { environment } from "src/environments/environment";
import Swal from "sweetalert2";

@Injectable({ providedIn: "root" })
export class InterceptService implements HttpInterceptor {
  constructor(private router: Router, private appService: AppService) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const hasToken =
      request.url.split("/")[0] != "login" ||
      (request.url.split("/")[0] != "users" && request.method != "post");

    request = request.clone({
      url: environment.serverUrl + `${request.url}`,
    });

    if (hasToken) {
      request = request.clone({
        setHeaders: {
          "Content-Type": "application/json",
          "X-Auth-Token": localStorage.getItem("token") || "",
        },
      });
    }

    return next.handle(request).pipe(
      catchError((err) => {
        if (err.status === 401 && hasToken) {
          setTimeout(() => {
            Swal.fire({
              title: "Sessão Expirada!",
              text: "Por favor, faça login novamente no sistema.",
              icon: "error",
            }).then(() => {
              localStorage.clear();
              this.appService.verifyMenuSubject.next(false);
              this.router.navigate([""]);
            });
          }, 1);
        }

        const error = err.error || err.statusText;
        return throwError(error);
      })
    );
  }
}
