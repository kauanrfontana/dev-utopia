import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable, tap } from "rxjs";
import { IBasicResponse } from "../shared/interfaces/IBasicResponse.interface";
import { Router } from "@angular/router";

interface IAuthResponse {
  token: string;
  refresh_token: string;
}
@Injectable({ providedIn: "root" })
export class AuthService {
  constructor(private http: HttpClient, private router: Router) {}

  login(credentials: {
    email: string;
    password: string;
  }): Observable<IAuthResponse> {
    let headers = new HttpHeaders();
    headers = headers.set("Content-Type", "application/json");

    return this.http
      .post<IAuthResponse>("login", credentials, { headers })
      .pipe(
        tap((response: IAuthResponse) => {
          localStorage.clear();
          localStorage.setItem("token", response.token);
          localStorage.setItem("refresh_token", response.refresh_token);
        })
      );
  }

  register(user: {
    email: string;
    password: string;
    name: string;
  }): Observable<IBasicResponse> {
    return this.http.post<IBasicResponse>("users", user);
  }

  logout(){
    localStorage.clear();
    this.router.navigate(["./auth"])
  }
}
