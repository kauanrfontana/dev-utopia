import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";

@Injectable({ providedIn: "root" })
export class UserService {
  constructor(private http: HttpClient) {}

  getUserData(userId?: number) {
    return this.http.get("user" + (userId && "/" + userId));
  }
}
