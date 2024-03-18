import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";

@Injectable({ providedIn: "root" })
export class LocationSevice {
  constructor(private http: HttpClient) {}

  getCountries(): Observable<any> {
    return this.http.get("locations?type=countries");
  }
}
