import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { IResponse } from "../shared/interfaces/IResponse.interface";

@Injectable({ providedIn: "root" })
export class AuthService {
  constructor(private http: HttpClient) {}

  login(credentials: { email: string; password: string }) {
    return this.http.post("login", credentials);
  }

  register(user: {
    email: string;
    password: string;
    name: string;
  }): Observable<IResponse> {
    return this.http.post<IResponse>("users", user);
  }
}
