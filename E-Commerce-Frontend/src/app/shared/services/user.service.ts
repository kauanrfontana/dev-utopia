import { User } from "../models/User";
import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import {
  IBasicResponseData,
  IBasicResponseMessage,
} from "../models/IBasicResponse.interfaces";
import { Observable } from "rxjs";

@Injectable({ providedIn: "root" })
export class UserService {
  userData = (): User => {
    let userData = localStorage.getItem("userData");
    if (userData) return JSON.parse(userData);
    return new User();
  };

  constructor(private http: HttpClient) {}

  getUserData(userId?: number): Observable<IBasicResponseData<User>> {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.get<IBasicResponseData<User>>("user" + paramUserId);
  }

  updateUserData(user: User): Observable<IBasicResponseMessage> {
    return this.http.put<IBasicResponseMessage>("user", user);
  }

  updatePassword(changePasswordData: {
    currentPassword: string;
    newPassword: string;
  }): Observable<IBasicResponseMessage> {
    return this.http.put<IBasicResponseMessage>("password", changePasswordData);
  }

  updateUserRole(
    newRoleCategory: number,
    userId?: number
  ): Observable<IBasicResponseMessage> {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.put<IBasicResponseMessage>("userRole" + paramUserId, {
      newRoleCategory,
    });
  }
}
