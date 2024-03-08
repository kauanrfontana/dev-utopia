import { Injectable } from "@angular/core";
import {
  HttpEvent,
  HttpInterceptor,
  HttpHandler,
  HttpRequest,
  HttpResponse,
} from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError, tap } from "rxjs/operators";
import { Router } from "@angular/router";
import { environment } from "src/environments/environment";
import Swal from "sweetalert2";

@Injectable({ providedIn: "root" })
export class InterceptService implements HttpInterceptor {
  constructor(private router: Router) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const saveToken =
      request.url.split("/")[0] != "login" ||
      (request.url.split("/")[0] != "users" && request.method != "post");

    request = request.clone({
      url: environment.serverUrl + `${request.url}`,
    });

    if (saveToken) {
      request = request.clone({
        setHeaders: {
          "Content-Type": "application/json",
          "X-Auth-Token": localStorage.getItem("token") || "",
        },
      });
    }

    return next.handle(request).pipe(
      tap((res) => {
        if (res.type === 0) return;

        if (res instanceof HttpResponse && saveToken) {
          localStorage.setItem("token", res.headers.get("X-Auth-Token") || "");
        }
      }),
      catchError((err) => {
        if (err.status === 401) {
          localStorage.clear();

          Swal.fire(
            "Sessão Expirada!",
            "Por favor, faça login novamente no sistema.",
            "error"
          ).then(() => {
            this.router.navigate([""]);
          });
        }

        const error = err.error || err.statusText;
        return throwError(error);
      })
    );
  }
}
